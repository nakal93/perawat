<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Request;
use Spatie\Activitylog\Facades\Activity;

class LogLogout
{
    public function handle(Logout $event): void
    {
        if ($event->user) {
            Activity::causedBy($event->user)
                ->performedOn($event->user)
                ->withProperties([
                    'ip' => Request::ip(),
                    'user_agent' => Request::header('User-Agent'),
                    'guard' => $event->guard,
                ])
                ->event('logout')
                ->log('User logged out');
        }
    }
}
