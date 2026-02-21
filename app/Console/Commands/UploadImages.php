<?php

namespace App\Console\Commands;

use App\Models\CampPage;
use App\Models\Page;
use App\Models\Speaker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadImages extends Command
{
    protected $signature = 'app:upload-images
                            {--dry-run : Preview all actions without making changes}
                            {--source= : Source directory (default: ~/Downloads/indian_creek_images)}';

    protected $description = 'Upload downloaded images to S3 and update DB references';

    private bool $dryRun = false;
    private string $source;
    private int $uploaded = 0;
    private int $skipped = 0;
    private int $dbUpdates = 0;

    public function handle(): int
    {
        $this->dryRun = $this->option('dry-run');
        $this->source = $this->option('source')
            ?? $_SERVER['HOME'] . '/Downloads/indian_creek_images';

        if (! is_dir($this->source)) {
            $this->error("Source directory not found: {$this->source}");
            return 1;
        }

        if ($this->dryRun) {
            $this->info('=== DRY RUN MODE — no changes will be made ===');
            $this->newLine();
        }

        $this->step1_uploadFiles();
        $this->step2_confirmDirectMatches();
        $this->step3_remapSpeakerImages();
        $this->step4_remapVideo();
        $this->step5_updateContentUrls();
        $this->step6_reportUnmappable();

        $this->newLine();
        $this->info("=== Summary ===");
        $this->info("Files uploaded: {$this->uploaded}");
        $this->info("Files skipped (already exist): {$this->skipped}");
        $this->info("DB updates: {$this->dbUpdates}");

        return 0;
    }

    /**
     * Step 1: Upload all media files from the source directory to S3.
     */
    private function step1_uploadFiles(): void
    {
        $this->info('--- Step 1: Upload files to S3 ---');

        $directories = [
            '' => 'Root',
            'downloads' => 'downloads',
            'page-attachments' => 'page-attachments',
            'page-images' => 'page-images',
            'speaker-images' => 'speaker-images',
            'videos' => 'videos',
        ];

        foreach ($directories as $subdir => $label) {
            $dir = $subdir === '' ? $this->source : $this->source . '/' . $subdir;

            if (! is_dir($dir)) {
                $this->warn("  Directory not found, skipping: {$label}");
                continue;
            }

            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;

                $fullPath = $dir . '/' . $file;

                // Skip directories (nested subdirs like downloads/downloads/)
                if (is_dir($fullPath)) continue;

                // Skip .php files and .DS_Store
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if ($ext === 'php' || $file === '.DS_Store') continue;

                $s3Path = $subdir === '' ? $file : $subdir . '/' . $file;

                $this->uploadFile($fullPath, $s3Path);
            }
        }

        $this->newLine();
    }

    /**
     * Step 2: Confirm direct DB path matches were uploaded.
     */
    private function step2_confirmDirectMatches(): void
    {
        $this->info('--- Step 2: Verify direct DB path matches ---');

        $checks = [
            ['table' => 'pages', 'column' => 'image', 'id' => 5, 'label' => 'Work at ICBC'],
            ['table' => 'pages', 'column' => 'image', 'id' => 7, 'label' => 'Directions and Location'],
            ['table' => 'pages', 'column' => 'image', 'id' => 11, 'label' => 'Support ICBC'],
            ['table' => 'camp_pages', 'column' => 'step_3_download', 'id' => 1, 'label' => 'Step 3 Download'],
            ['table' => 'camp_pages', 'column' => 'step_4_download', 'id' => 1, 'label' => 'Step 4 Download'],
        ];

        foreach ($checks as $check) {
            $value = DB::table($check['table'])->where('id', $check['id'])->value($check['column']);
            if ($value && Storage::disk('public')->exists($value)) {
                $this->line("  ✓ {$check['label']}: {$value} — exists on S3");
            } elseif ($value) {
                $this->warn("  ✗ {$check['label']}: {$value} — NOT found on S3");
            } else {
                $this->line("  - {$check['label']}: no value in DB");
            }
        }

        $this->newLine();
    }

    /**
     * Step 3: Remap speaker images by matching ULID chronological order to speaker ID order.
     */
    private function step3_remapSpeakerImages(): void
    {
        $this->info('--- Step 3: Remap speaker images ---');

        $speakerDir = $this->source . '/speaker-images';
        if (! is_dir($speakerDir)) {
            $this->error('  speaker-images directory not found!');
            return;
        }

        // Get downloaded files sorted alphabetically (ULID = chronological)
        $files = array_filter(scandir($speakerDir), function ($f) use ($speakerDir) {
            return $f !== '.' && $f !== '..' && ! is_dir($speakerDir . '/' . $f);
        });
        sort($files); // Alphabetical = chronological for ULIDs
        $files = array_values($files);

        // Get speakers ordered by ID
        $speakers = Speaker::orderBy('id')->get();

        $this->info("  Found {$speakers->count()} speakers and " . count($files) . " downloaded files");
        $this->newLine();

        // Build mapping table
        $headers = ['Speaker ID', 'Speaker Name', 'Old Path', 'New Path', 'Status'];
        $rows = [];

        foreach ($speakers as $index => $speaker) {
            if (! isset($files[$index])) {
                $rows[] = [$speaker->id, $speaker->name, $speaker->image, '???', 'NO FILE'];
                continue;
            }

            $newPath = 'speaker-images/' . $files[$index];
            $oldPath = $speaker->image;
            $status = $oldPath === $newPath ? 'UNCHANGED' : 'REMAP';

            $rows[] = [$speaker->id, $speaker->name, $oldPath, $newPath, $status];

            if ($status === 'REMAP') {
                if (! $this->dryRun) {
                    // Delete old S3 file if it exists
                    if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }

                    $speaker->update(['image' => $newPath]);
                    $this->dbUpdates++;
                } else {
                    $this->dbUpdates++;
                }
            }
        }

        $this->table($headers, $rows);

        // Report unmapped files
        if (count($files) > $speakers->count()) {
            $extras = array_slice($files, $speakers->count());
            $this->newLine();
            $this->warn('  Extra speaker images (uploaded but not mapped):');
            foreach ($extras as $f) {
                $this->line("    - speaker-images/{$f}");
            }
        }

        $this->newLine();
    }

    /**
     * Step 4: Remap the camp page hero video.
     */
    private function step4_remapVideo(): void
    {
        $this->info('--- Step 4: Remap hero video ---');

        $videoDir = $this->source . '/videos';
        if (! is_dir($videoDir)) {
            $this->error('  videos directory not found!');
            return;
        }

        $files = array_filter(scandir($videoDir), function ($f) use ($videoDir) {
            return $f !== '.' && $f !== '..' && ! is_dir($videoDir . '/' . $f);
        });
        $files = array_values($files);

        if (count($files) !== 1) {
            $this->warn("  Expected 1 video file, found " . count($files));
            return;
        }

        $newPath = 'videos/' . $files[0];
        $campPage = CampPage::first();
        $oldPath = $campPage->hero_video;

        $this->line("  Old: {$oldPath}");
        $this->line("  New: {$newPath}");

        if ($oldPath !== $newPath) {
            if (! $this->dryRun) {
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                $campPage->update(['hero_video' => $newPath]);
                $this->dbUpdates++;
                $this->info('  ✓ Updated');
            } else {
                $this->info('  → Would update');
                $this->dbUpdates++;
            }
        } else {
            $this->line('  Already matches, no update needed');
        }

        $this->newLine();
    }

    /**
     * Step 5: Replace old URL prefixes in page/event HTML content.
     */
    private function step5_updateContentUrls(): void
    {
        $this->info('--- Step 5: Update content URLs ---');

        $oldPrefix = 'https://indiancreek.camp/storage/';
        $newPrefix = 'https://ewr1.vultrobjects.com/indiancreek/';

        // Update pages.content
        $pages = Page::whereNotNull('content')
            ->where('content', 'like', "%{$oldPrefix}%")
            ->get();

        foreach ($pages as $page) {
            $original = $page->content;
            $updated = str_replace($oldPrefix, $newPrefix, $original);

            $count = substr_count($original, $oldPrefix);
            $this->line("  Page \"{$page->title}\" (ID {$page->id}): {$count} URL(s) to replace");

            if (! $this->dryRun) {
                $page->update(['content' => $updated]);
                $this->dbUpdates++;
                $this->info("    ✓ Updated");
            } else {
                $this->info("    → Would update");
                $this->dbUpdates++;
            }
        }

        if ($pages->isEmpty()) {
            $this->line('  No pages with old URLs found');
        }

        $this->newLine();
    }

    /**
     * Step 6: Report items that couldn't be automatically resolved.
     */
    private function step6_reportUnmappable(): void
    {
        $this->info('--- Step 6: Unmappable items ---');

        $items = [
            'camp-types/wNGdlMuaHD... (Teen Camp)' => 'No camp-types/ dir in downloads',
            'camp-types/n7b3snG2TS... (Junior Camp)' => 'No camp-types/ dir in downloads',
            'camp-types/ss7V89Utcz... (Combo Camp)' => 'No camp-types/ dir in downloads',
            'images/sTXPeegOnq... (HomePage map)' => 'No images/ dir in downloads',
            'page-images/Ti34EQv3P8... (Camp Rentals page)' => 'App-generated name, not in downloads',
        ];

        // Root-level files not mapped to any DB column
        $rootFiles = array_filter(scandir($this->source), function ($f) {
            return ! in_array($f, ['.', '..', '.DS_Store'])
                && ! is_dir($this->source . '/' . $f)
                && pathinfo($f, PATHINFO_EXTENSION) !== 'php';
        });

        foreach ($rootFiles as $f) {
            $items[$f] = 'Root-level file — uploaded but not mapped to any DB column';
        }

        $this->table(
            ['Item', 'Reason'],
            collect($items)->map(fn ($reason, $item) => [$item, $reason])->values()->toArray()
        );
    }

    /**
     * Upload a local file to S3 if it doesn't already exist.
     */
    private function uploadFile(string $localPath, string $s3Path): void
    {
        if (Storage::disk('public')->exists($s3Path)) {
            $this->line("  skip (exists): {$s3Path}");
            $this->skipped++;
            return;
        }

        if ($this->dryRun) {
            $this->line("  would upload: {$s3Path}");
            $this->uploaded++;
            return;
        }

        $stream = fopen($localPath, 'r');
        Storage::disk('public')->put($s3Path, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        $this->info("  uploaded: {$s3Path}");
        $this->uploaded++;
    }
}
