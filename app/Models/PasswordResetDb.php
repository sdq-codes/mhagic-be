<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetDb extends Model
{
    protected  $guarded = [];

    protected $table = 'password_resets';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
