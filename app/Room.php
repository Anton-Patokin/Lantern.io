<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;


    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    protected $dates = ['deleted_at'];
}
