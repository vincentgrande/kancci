<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkGroupUser extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function workgroup()
    {
        return $this->belongsTo('App\WorkGroup');
    }
}
