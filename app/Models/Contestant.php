<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contestant extends Model
{
    protected  $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'userIds');
    }

    public function uploads(){
        return $this->hasMany(Upload::class, 'uploadedBy');
    }

    public function fans(){
        return $this->hasMany(Fan::class, 'following');
    }
}
