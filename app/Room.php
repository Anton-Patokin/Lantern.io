<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;


    public function files()
    {
        return $this->hasMany('App\File');
    }

    protected $dates = ['deleted_at'];
}
