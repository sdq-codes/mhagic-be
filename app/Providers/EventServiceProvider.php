<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\ExampleEvent::class => [
            \App\Listeners\ExampleListener::class,
        ],
        \App\Events\AccountRegistered::class => [
            \App\Listeners\AccountRegisteredListener::class,
        ],
        \App\Events\PasswordReset::class => [
            \App\Listeners\PasswordResetListener::class,
        ],
    ];
}
