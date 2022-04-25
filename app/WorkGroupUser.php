<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkGroupUser extends Model
{
    protected $fillable = ['user_id', 'workgroup_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workgroup()
    {
        return $this->belongsTo('App\WorkGroup');
    }
}
