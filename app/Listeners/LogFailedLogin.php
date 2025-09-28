<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Spatie\Activitylog\Facades\Activity;

class LogFailedLogin
{
    public function handle(Failed $event): void
    {
        $email = is_array($event->credentials) ? ($event->credentials['email'] ?? 'unknown') : 'unknown';
        $ip = Request::ip();

        // Log the failure
        Activity::withProperties([
                'ip' => $ip,
                'email' => $email,
                'user_agent' => Request::header('User-Agent'),
                'guard' => $event->guard,
            ])
            ->event('login_failed')
            ->log('Failed login attempt');

        // Simple brute force counter per ip+email
        $key = sprintf('login:fail:%s:%s', $ip, strtolower((string) $email));
        $startKey = sprintf('login:fail:start:%s:%s', $ip, strtolower((string) $email));
        $count = Cache::increment($key);
        // Expire counter after 15 minutes
        if ($count === 1) {
            Cache::put($key, 1, now()->addMinutes(15));
            Cache::put($startKey, now(), now()->addMinutes(15));
        }

        $threshold = (int) Config::get('app.login_attempts', 5); // from settings
        if ($count >= max(3, $threshold)) {
            Activity::withProperties([
                    'ip' => $ip,
                    'email' => $email,
                    'fail_count' => $count,
                    'window_minutes' => 15,
                ])
                ->event('bruteforce_warning')
                ->log('Potential brute-force detected');
        }
    }
}
