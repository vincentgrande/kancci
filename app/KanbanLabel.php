<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KanbanLabel extends Model
{
    protected $fillable = ['kanban_id', 'label_id'];

    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }

    public function label()
    {
        return $this->belongsTo('App\Label');
    }
}
