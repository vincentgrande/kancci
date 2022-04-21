<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KanbanUser extends Model
{
    protected $fillable = ['user_id', 'kanban_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }
}
