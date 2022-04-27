<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkgroupPendingInvitation extends Model {

    protected $fillable = ['workgroup_id', 'email'];

    /**
     * Return the workgroup from the PendingInvitation
     *
     * @return BelongsTo
     */
    public function workgroup()
    {
        return $this->belongsTo('App\WorkGroup');
    }

    /**
     * Return the user from the PendingInvitation
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
