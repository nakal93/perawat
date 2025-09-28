<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenKaryawan;

class MigrateDokumenToPrivate extends Command
{
    protected $signature = 'dokumen:migrate-private {--dry-run : Only show what would be moved}';
    protected $description = 'Migrate legacy dokumen files from public disk to private local disk and update DB paths if needed';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $moved = 0; $skipped = 0; $missing = 0; $errors = 0; $already = 0;

        $this->info(($dry ? '[DRY-RUN] ' : '').'Scanning dokumen_karyawan records...');

        DokumenKaryawan::chunk(200, function ($batch) use (&$moved, &$skipped, &$missing, &$errors, &$already, $dry) {
            foreach ($batch as $doc) {
                $path = $doc->file_path;
                if (!$path) { $skipped++; continue; }

                $onLocal = Storage::disk('local')->exists($path);
                $onPublic = Storage::disk('public')->exists($path);

                if ($onLocal && !$onPublic) { $already++; continue; }

                if ($onPublic && !$onLocal) {
                    if ($dry) {
                        $this->line("Would move public://{$path} -> local://{$path}");
                        continue;
                    }
                    try {
                        $dir = dirname($path);
                        if ($dir && $dir !== '.' && !Storage::disk('local')->exists($dir)) {
                            Storage::disk('local')->makeDirectory($dir);
                        }
                        $contents = Storage::disk('public')->get($path);
                        Storage::disk('local')->put($path, $contents);
                        // Optional: Keep or remove public copy. We'll remove to enforce privacy.
                        Storage::disk('public')->delete($path);
                        $moved++;
                    } catch (\Throwable $e) {
                        $errors++;
                        $this->error("Failed moving {$path}: ".$e->getMessage());
                    }
                    continue;
                }

                if (!$onLocal && !$onPublic) { $missing++; continue; }

                // Both exist: prefer local, remove public
                if ($onLocal && $onPublic) {
                    if ($dry) {
                        $this->line("Would delete redundant public copy: public://{$path}");
                    } else {
                        Storage::disk('public')->delete($path);
                    }
                    $already++;
                }
            }
        });

        $this->info("Completed. moved={$moved}, already_private={$already}, missing={$missing}, skipped={$skipped}, errors={$errors}");
        return 0;
    }
}
