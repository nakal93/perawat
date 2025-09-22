<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS URLs when behind proxy or in production
        if (app()->environment('production') || 
            (request()->hasHeader('X-Forwarded-Proto') && request()->header('X-Forwarded-Proto') === 'https')) {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        // Sinkronkan settings dari cache ke config runtime di setiap request
        $map = [
            'maintenance_mode'    => 'app.maintenance_mode',
            'auto_approval'       => 'app.auto_approval',
            'email_notifications' => 'app.email_notifications',
            'max_file_size'       => 'app.max_file_size',
            'two_factor_auth'     => 'app.two_factor_auth',
            'password_complexity' => 'app.password_complexity',
            'session_timeout'     => 'session.lifetime',
            'login_attempts'      => 'app.login_attempts',
        ];

        foreach ($map as $cacheKey => $configKey) {
            $val = Cache::get("settings.$cacheKey");
            if (!is_null($val)) {
                Config::set($configKey, $val);
            }
        }

        // Share maintenance secret ke semua view untuk keperluan info opsional
        View::composer('*', function ($view) {
            $view->with('maintenanceSecret', Cache::get('settings.maintenance_secret'));
        });
    }
}
