<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Request;
use Spatie\Activitylog\Facades\Activity;

class LogLockout
{
    public function handle(Lockout $event): void
    {
        $ip = Request::ip();
        $email = $event->request->input('email');
        Activity::withProperties([
                'ip' => $ip,
                'email' => $email,
                'user_agent' => Request::header('User-Agent'),
            ])
            ->event('login_lockout')
            ->log('User locked out due to too many attempts');
    }
}
