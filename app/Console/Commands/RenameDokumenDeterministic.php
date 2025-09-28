<?php

namespace App\Console\Commands;

use App\Models\DokumenKaryawan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RenameDokumenDeterministic extends Command
{
    protected $signature = 'dokumen:rename-deterministic {--dry-run : Hanya menampilkan rencana perubahan tanpa melakukan perubahan} {--chunk=200 : Jumlah data per batch}';
    protected $description = 'Ubah semua file dokumen karyawan ke format NamaUser-Kategori.ext, tangani tabrakan, dan update DB';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $chunk = (int) $this->option('chunk');

        $total = 0; $renamed = 0; $skipped = 0; $missing = 0; $errors = 0;

        DokumenKaryawan::with(['karyawan.user', 'kategoriDokumen'])
            ->orderBy('id')
            ->chunkById($chunk, function ($rows) use (&$total, &$renamed, &$skipped, &$missing, &$errors, $dry) {
                foreach ($rows as $d) {
                    $total++;

                    if (!$d->file_path || !$d->file_name) {
                        $skipped++; continue;
                    }

                    // Tentukan disk asal: prioritaskan privat
                    $disk = Storage::disk('local')->exists($d->file_path) ? 'local' : (Storage::disk('public')->exists($d->file_path) ? 'public' : null);
                    if (!$disk) { $missing++; $this->warn("Missing: #{$d->id} {$d->file_path}"); continue; }

                    $userName = optional(optional($d->karyawan)->user)->name ?: 'User';
                    $kategori = optional($d->kategoriDokumen)->nama_kategori ?: 'Dokumen';

                    $namePart = Str::of($userName)
                        ->replace(['/', '\\', '_', '-'], ' ')
                        ->squish()
                        ->lower()
                        ->title()
                        ->replaceMatches('/[^A-Za-z0-9\s]+/', '')
                        ->replaceMatches('/\s+/', '-')
                        ->trim('-');
                    $katPart = Str::of($kategori)
                        ->replace(['/', '\\'], '-')
                        ->replaceMatches('/[^A-Za-z0-9\-\s_]+/', '')
                        ->trim()
                        ->replaceMatches('/[\s_]+/', '-')
                        ->trim('-');

                    // Ekstensi dari file_name/file_path
                    $ext = strtolower(pathinfo($d->file_name ?: $d->file_path, PATHINFO_EXTENSION));
                    if (!$ext) { $skipped++; continue; }

                    $base = $namePart.'-'.$katPart;
                    $candidate = $base.'.'.$ext;
                    $i = 2;
                    while (Storage::disk('local')->exists('dokumen/'.$candidate) || Storage::disk('public')->exists('dokumen/'.$candidate)) {
                        $candidate = $base.'-'.$i.'.'.$ext;
                        $i++;
                    }

                    // Jika sudah sama persis, skip
                    if (basename($d->file_path) === $candidate && $d->file_name === $candidate) {
                        $skipped++; continue;
                    }

                    $newPath = 'dokumen/'.$candidate;
                    $action = $dry ? 'PLAN' : 'RENAME';
                    $this->line("[$action] #{$d->id} {$d->file_path} -> {$newPath}");

                    if (!$dry) {
                        try {
                            // Salin ke disk privat (local) dengan nama baru
                            $stream = Storage::disk($disk)->readStream($d->file_path);
                            if (!$stream) { $missing++; continue; }

                            $ok = Storage::disk('local')->put($newPath, stream_get_contents($stream));
                            if (is_resource($stream)) { fclose($stream); }
                            if (!$ok) { $errors++; $this->error("Gagal menulis: {$newPath}"); continue; }

                            // Hapus file lama dari kedua disk (aman untuk legacy)
                            Storage::disk('local')->delete($d->file_path);
                            Storage::disk('public')->delete($d->file_path);

                            // Update DB
                            $d->file_path = $newPath;
                            $d->file_name = $candidate;
                            $d->save();
                            $renamed++;
                        } catch (\Throwable $e) {
                            $errors++;
                            $this->error("Error #{$d->id}: ".$e->getMessage());
                        }
                    }
                }
            });

        $this->info("Done. total={$total} renamed={$renamed} skipped={$skipped} missing={$missing} errors={$errors}");
        return Command::SUCCESS;
    }
}
