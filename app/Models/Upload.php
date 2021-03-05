<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected  $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'uploadedBy');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'uploadId');
    }
}
