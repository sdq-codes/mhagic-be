<?php

namespace App\Events;

use App\Models\User;

class AccountRegistered extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */

    /** @var User  */
    public $user;

    /**
     * AccountRegistered constructor.
     *
     * @param User         $user
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }
}
