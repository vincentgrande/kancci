<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkGroupUser extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'workgroup_id', 'isAdmin'];

    /**
     * Get the user associated with the workgroupuser
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the workgroup associated with the workgroupuser
     * @return BelongsTo
     */
    public function workgroup()
    {
        return $this->belongsTo('App\WorkGroup');
    }
}
