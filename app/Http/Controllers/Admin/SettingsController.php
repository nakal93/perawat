<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    public function index()
    {
        // Ambil dari config yang sudah disinkronkan dengan cache via AppServiceProvider
        $settings = [
            'maintenance_mode'    => (bool) Config::get('app.maintenance_mode', false),
            'auto_approval'       => (bool) Config::get('app.auto_approval', false),
            'email_notifications' => (bool) Config::get('app.email_notifications', true),
            'max_file_size'       => (int) Config::get('app.max_file_size', 10),
            'two_factor_auth'     => (bool) Config::get('app.two_factor_auth', false),
            'password_complexity' => (bool) Config::get('app.password_complexity', true),
            'session_timeout'     => (int) Config::get('session.lifetime', 120),
            'login_attempts'      => (int) Config::get('app.login_attempts', 5),
            'maintenance_secret'  => Cache::get('settings.maintenance_secret'),
        ];
        
        return view('admin.settings', compact('settings'));
    }
    
    public function update(Request $request)
    {
        // Validasi input numerik; checkbox ditangani via boolean() supaya ada nilai meski unchecked
        $validated = $request->validate([
            'max_file_size' => 'nullable|integer|min:1|max:100',
            'session_timeout' => 'nullable|integer|min:5|max:1440',
            'login_attempts' => 'nullable|integer|min:1|max:10',
        ]);

        // Normalisasi nilai settings (pastikan semua key ada)
        $settings = [
            'maintenance_mode'    => $request->boolean('maintenance_mode'),
            'auto_approval'       => $request->boolean('auto_approval'),
            'email_notifications' => $request->boolean('email_notifications'),
            'two_factor_auth'     => $request->boolean('two_factor_auth'),
            'password_complexity' => $request->boolean('password_complexity'),
            'max_file_size'       => (int) ($validated['max_file_size'] ?? Config::get('app.max_file_size', 10)),
            'session_timeout'     => (int) ($validated['session_timeout'] ?? Config::get('session.lifetime', 120)),
            'login_attempts'      => (int) ($validated['login_attempts'] ?? Config::get('app.login_attempts', 5)),
        ];

        // Simpan seluruh settings ke cache (source of truth sementara)
        foreach ($settings as $key => $value) {
            Cache::put("settings.{$key}", $value, now()->addDays(30));
            // Update config runtime agar halaman ini langsung merefleksikan perubahan
            if ($key === 'session_timeout') {
                Config::set('session.lifetime', $value);
            } else {
                Config::set("app.$key", $value);
            }
        }

        // Tangani Mode Maintenance menggunakan Artisan down/up
        $secret = Cache::get('settings.maintenance_secret');
        $message = 'Pengaturan berhasil disimpan';
        try {
            if ($settings['maintenance_mode']) {
                // Generate secret bila belum ada agar admin bisa bypass
                if (!$secret) {
                    $secret = 'admin-'.substr(hash('sha256', config('app.key').'-'.now()), 0, 12);
                    Cache::put('settings.maintenance_secret', $secret, now()->addDays(30));
                }
                Artisan::call('down', ['secret' => $secret]);
                $message = "Mode maintenance AKTIF.";
                // Redirect melalui path secret agar cookie bypass terpasang, lalu kembali ke halaman settings
                $target = '/admin/settings';
                return redirect(url($secret.$target))->with('success', $message);
            } else {
                Artisan::call('up');
                // optional: hapus secret
                Cache::forget('settings.maintenance_secret');
                $message = 'Mode maintenance DIMATIKAN dan pengaturan disimpan';
            }
        } catch (\Throwable $e) {
            // Bila gagal menjalankan perintah, tetap lanjut tanpa memutus alur
            // dan tampilkan informasi minimal
            $message .= ' (catatan: gagal menjalankan perintah maintenance: '.$e->getMessage().')';
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    public function systemInfo()
    {
        return response()->json([
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'database_connection' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'queue_driver' => config('queue.default'),
            'mail_driver' => config('mail.default'),
        ]);
    }
}