<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class WorkGroup extends Model
{
    /**
     * @var string
     */
    protected $table = 'workgroups';
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'logo','updated_at', 'created_by'];
    /**
     * @var string[]
     */
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    /**
     * Get the creator associated with the WorkGroup
     *
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the users associated with the Workgroup
     *
     * @return belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the kanban associated with the WorkGroup
     *
     * @return HasMany
     */
    public function kanban()
    {
        return $this->hasMany(Kanban::class);
    }

    /**
     * @return HasMany
     */
    public function workgroup_user()
    {
        return $this->hasMany('App\WorkGroupUser');
    }
}
