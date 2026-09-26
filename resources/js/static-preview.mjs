import { createServer } from 'node:http';
import { readFile, stat } from 'node:fs/promises';
import { dirname, extname, resolve, sep } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '../../dist');
const port = Number(process.env.PORT ?? 8766);
const types = { '.html': 'text/html; charset=utf-8', '.css': 'text/css', '.js': 'text/javascript', '.json': 'application/json', '.xml': 'application/xml', '.txt': 'text/plain', '.jpg': 'image/jpeg', '.jpeg': 'image/jpeg', '.png': 'image/png', '.avif': 'image/avif', '.webp': 'image/webp', '.svg': 'image/svg+xml', '.pdf': 'application/pdf', '.mp4': 'video/mp4', '.woff2': 'font/woff2' };
await stat(resolve(root, 'index.html'));
createServer(async (request, response) => {
    if (!['GET', 'HEAD'].includes(request.method)) {
        response.writeHead(405, { Allow: 'GET, HEAD' }).end();
        return;
    }
    try {
        const pathname = decodeURIComponent(new URL(request.url, 'http://localhost').pathname);
        let path = resolve(root, '.' + pathname);
        if (path !== root && !path.startsWith(root + sep)) {
            response.writeHead(403).end();
            return;
        }
        const info = await stat(path);
        if (info.isDirectory()) path = resolve(path, 'index.html');
        const data = await readFile(path);
        response.writeHead(200, { 'Content-Type': types[extname(path)] ?? 'application/octet-stream', 'Content-Length': data.length, 'Cache-Control': 'no-store' });
        response.end(request.method === 'HEAD' ? undefined : data);
    } catch {
        const data = await readFile(resolve(root, '404.html'));
        response.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
        response.end(request.method === 'HEAD' ? undefined : data);
    }
}).listen(port, '127.0.0.1', () => console.log(`Static preview: http://127.0.0.1:${port}`));
