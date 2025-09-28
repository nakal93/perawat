<?php

namespace App\Providers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Login::class => [\App\Listeners\LogSuccessfulLogin::class],
        Failed::class => [\App\Listeners\LogFailedLogin::class],
        Logout::class => [\App\Listeners\LogLogout::class],
        Lockout::class => [\App\Listeners\LogLockout::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
