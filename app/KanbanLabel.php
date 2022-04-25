<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KanbanLabel extends Model
{
    protected $fillable = ['kanban_id', 'label_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function label()
    {
        return $this->belongsTo('App\Label');
    }
}
