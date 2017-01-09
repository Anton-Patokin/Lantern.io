<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;


    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    protected $dates = ['deleted_at'];
}
