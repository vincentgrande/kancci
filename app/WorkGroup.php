<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WorkGroup extends Model
{
    /**
     * @var string
     */
    protected $table = 'workgroups';
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'logo', 'updated_at', 'created_by'];
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the users associated with the Workgroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the kanban associated with the WorkGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kanban()
    {
        return $this->hasMany(Kanban::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workgroup_user()
    {
        return $this->hasMany('App\WorkGroupUser');
    }
}
