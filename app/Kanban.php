<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kanban extends Model
{
    protected $fillable = ['title', 'order', 'visibility', 'background', 'updated_at', 'created_by', 'workgroup_id'];
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    /**
     * Get the boards associated with the Kanban
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    /**
     * Get the creator associated with the Kanban
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class,'id','created_by');
    }

    /**
     * Get the workgroup associated with the Kanban
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workgroup()
    {
        return $this->hasOne(WorkGroup::class,'id','workgroup_id');
    }

    /**
     * Get the labels associated with the Kanban
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function kanban_label()
    {
        return $this->hasMany('App\KanbanLabel');
    }
}
