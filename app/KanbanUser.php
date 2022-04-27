<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KanbanUser extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'kanban_id'];

    /**
     *  Get the user associated with the KanbanUser
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     *  Get the kanban associated with the KanbanUser
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }
}
