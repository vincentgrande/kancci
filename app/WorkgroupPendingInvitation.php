<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkgroupPendingInvitation extends Model {

    protected $fillable = ['workgroup_id', 'email'];

    /**
     * @return BelongsTo
     */
    public function workgroup(): BelongsTo
    {
        return $this->belongsTo('App\WorkGroup');
    }
}
