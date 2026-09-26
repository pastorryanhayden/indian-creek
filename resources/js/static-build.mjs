import { cp, mkdir, readFile, rm, stat, writeFile } from 'node:fs/promises';
import { dirname, resolve, sep } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '../..');
const source = resolve(root, 'resources/static');
const output = resolve(root, 'dist');
const read = (name) => readFile(resolve(source, name), 'utf8');
const escape = (value) => value.replaceAll('&', '&amp;').replaceAll('"', '&quot;').replaceAll('<', '&lt;').replaceAll('>', '&gt;');
const [layout, navigation, footer, manifest] = await Promise.all([
    read('layout.html'), read('navigation.html'), read('footer.html'), read('pages.json'),
]);
const pages = JSON.parse(manifest);
const rendered = [];
const routes = new Set();
for (const page of pages) {
    if (!/^\/(?:[a-z0-9-]+(?:\/[a-z0-9-]+)*)?$/.test(page.path) || routes.has(page.path)) {
        throw new Error(`Invalid or duplicate page path: ${page.path}`);
    }
    routes.add(page.path);
    const contentPath = resolve(source, page.source);
    if (!contentPath.startsWith(source + sep)) throw new Error('Page source must stay inside resources/static');
    const content = await readFile(contentPath, 'utf8');
    const values = { title: escape(page.title), navigation, footer, content };
    const html = layout.replace(/\{\{(title|navigation|footer|content)\}\}/g, (_, key) => values[key]);
    if (/<form\b|browser-logger-active|_boost\/|<\?php/i.test(html)) {
        throw new Error(`Unexpected server-dependent content in ${page.path}`);
    }
    rendered.push({ path: page.path, html });
}
await rm(output, { recursive: true, force: true });
await mkdir(output, { recursive: true });
await cp(resolve(source, 'assets'), output, { recursive: true });
await cp(resolve(root, 'resources/js/static-camp.js'), resolve(output, 'static-camp.js'));
for (const page of rendered) {
    const target = resolve(output, '.' + page.path, 'index.html');
    await mkdir(dirname(target), { recursive: true });
    await writeFile(target, page.html);
}
const notFound = layout.replace(/\{\{(title|navigation|footer|content)\}\}/g, (_, key) => ({
    title: 'Page not found — Indian Creek Baptist Camp', navigation, footer,
    content: '<main class="p-12 text-center"><h1 class="text-6xl font-heading">Page not found</h1><p class="mt-6"><a href="/" class="underline">Return to the camp homepage</a></p></main>',
}[key]));
await writeFile(resolve(output, '404.html'), notFound);
await writeFile(resolve(output, 'robots.txt'), 'User-agent: *\nAllow: /\nSitemap: https://indiancreek.camp/sitemap.xml\n');
await writeFile(resolve(output, 'sitemap.xml'), '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n' + pages.map(page => `  <url><loc>https://indiancreek.camp${escape(page.path)}</loc></url>`).join('\n') + '\n</urlset>\n');
let references = 0;
for (const page of rendered) {
    const urls = Array.from(page.html.matchAll(/(?:src|href|poster)=["']([^"']+)["']/g), match => match[1]);
    urls.push(...Array.from(page.html.matchAll(/url\([\s'"]*([^)'"\s]+)/g), match => match[1]));
    for (const reference of urls) {
        if (!reference.startsWith('/') || reference.startsWith('//')) continue;
        const url = new URL(reference.replaceAll('&amp;', '&'), 'https://indiancreek.camp');
        const path = resolve(output, '.' + decodeURIComponent(url.pathname));
        if (path !== output && !path.startsWith(output + sep)) throw new Error(`Invalid reference: ${reference}`);
        try {
            const info = await stat(path);
            if (info.isDirectory()) await stat(resolve(path, 'index.html'));
        } catch {
            throw new Error(`Missing local link or asset on ${page.path}: ${reference}`);
        }
        references++;
    }
}
console.log(`Validated ${references} local links and media references.`);
console.log(`Built ${pages.length} pages into dist/ (HTML, CSS, JavaScript and public media only).`);
