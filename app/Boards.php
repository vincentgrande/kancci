<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boards extends Model
{
    protected $fillable = ['id', 'title', 'orderNo', 'updated_at', 'kanban_id', 'labels', 'cards', 'created_by'];
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
    public function kanban()
    {
        return $this->hasOne(Kanban::class);
    }
    public function creator()
    {
        return $this->hasOne(User::class);
    }
    public function Labels()
    {
        return $this->hasMany(Labels::class);
    }
}
