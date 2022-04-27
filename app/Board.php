<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'updated_at', 'kanban_id', 'created_by', 'isActive'];

    /**
     * @var string[]
     */
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    /**
     * Get the cards owned by the board
     *
     * @return HasMany
     */
    public function cards()
    {
        return $this->hasMany('App\Card');
    }

    /**
     * Get the kanban that owns the board
     *
     * @return BelongsTo
     */
    public function kanban()
    {
        return $this->belongsTo('App\Kanban');
    }

    /**
     * Get the creator that owns the board
     *
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the labels that owns the board
     *
     * @return HasMany
     */
    public function labels()
    {
        return $this->hasMany('App\Label');
    }
}
