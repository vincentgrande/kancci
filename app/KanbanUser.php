<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KanbanUser extends Model
{
    protected $fillable = ['user_id', 'kanban_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }
}
