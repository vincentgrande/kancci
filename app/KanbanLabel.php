<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KanbanLabel extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['kanban_id', 'label_id'];

    /**
     *  Get the kanban associated with the KanbanLabel
     * @return BelongsTo
     */
    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }

    /**
     *  Get the label associated with the KanbanLabel
     * @return BelongsTo
     */
    public function label()
    {
        return $this->belongsTo('App\Label');
    }
}
