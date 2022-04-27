<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkGroupUser extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'workgroup_id'];

    /**
     * Get the user associated with the workgroupuser
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the workgroup associated with the workgroupuser
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workgroup()
    {
        return $this->belongsTo('App\WorkGroup');
    }
}
