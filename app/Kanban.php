<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kanban extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'order', 'visibility', 'background', 'updated_at', 'created_by', 'workgroup_id'];
    /**
     * @var string[]
     */
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    /**
     * Get the boards associated with the Kanban
     * @return HasMany
     */
    public function boards()
    {
        return $this->hasMany('App\Board');
    }

    /**
     * Get the creator associated with the Kanban
     *
     * @return HasOne
     */
    public function creator()
    {
        return $this->hasOne('App\User');
    }

    /**
     * Get the workgroup associated with the Kanban
     *
     * @return HasOne
     */
    public function workgroup()
    {
        return $this->hasOne('App\WorkGroup');
    }

    /**
     * Get the labels associated with the Kanban
     * @return belongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany('App\Label');
    }

    /**
     * Get the user kanban_label with the Kanban
     * @return HasMany
     */
    public function kanban_label()
    {
        return $this->hasMany('App\KanbanLabel');
    }

    /**
     * Get the kanbanUser associated with the Kanban
     * @return HasMany
     */
    public function kanbanUser()
    {
        return $this->hasMany('App\User');
    }
}
