<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;
use Spatie\Activitylog\Facades\Activity;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        Activity::causedBy($event->user)
            ->performedOn($event->user)
            ->withProperties([
                'ip' => Request::ip(),
                'user_agent' => Request::header('User-Agent'),
                'guard' => $event->guard,
            ])
            ->event('login')
            ->log('User logged in');
    }
}
