<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['id', 'title', 'kanban_id'];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
    public function kanban()
    {
        return $this->hasOne('App\Kanban', 'id', 'kanban_id');
    }
}
