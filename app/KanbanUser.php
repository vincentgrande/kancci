<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KanbanUser extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'kanban_id'];

    /**
     *  Get the user associated with the KanbanUser
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     *  Get the kanban associated with the KanbanUser
     * @return BelongsTo
     */
    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }
}
