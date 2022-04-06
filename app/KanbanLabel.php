<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KanbanLabel extends Model
{
    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }

    public function label()
    {
        return $this->belongsTo('App\Label');
    }
}
