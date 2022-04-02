<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kanban extends Model
{
    protected $fillable = ['title', 'visibility', 'updated_at', 'users', 'kanban_id', 'workgroup_id', 'labels'];
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];
    public function boards()
    {
        return $this->hasMany(Board::class);
    }
    public function creator()
    {
        return $this->hasOne(User::class);
    }
    public function workgroups()
    {
        return $this->hasOne(WorkGroup::class);
    }
    public function labels()
    {
        return $this->hasMany(Label::class);
    }
}
