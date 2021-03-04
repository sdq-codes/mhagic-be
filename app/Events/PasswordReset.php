<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{


    /** @var User  */
    public $user;

    /**
     * AccountRegistered constructor.
     *
     * @param User         $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
