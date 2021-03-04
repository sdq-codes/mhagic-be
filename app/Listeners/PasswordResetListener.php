<?php

namespace App\Listeners;


use App\Events\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetNotifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PasswordResetListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @param PasswordReset $event
     */
    public function handle(PasswordReset $event)
    {
        $event->user->notify(new PasswordResetNotifications($event->user));
    }
}
