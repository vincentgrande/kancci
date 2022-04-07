<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['title', 'updated_at', 'kanban_id', 'created_by'];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    /**
     * Get the cards owned by the board
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get the kanban that owns the board
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kanban()
    {
        return $this->belongsTo(Kanban::class,'id','kanban_id');
    }

    /**
     * Get the creator that owns the board
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class,'id','created_by');
    }

    /**
     * Get the labels that owns the board
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labels()
    {
        return $this->hasMany(Label::class);
    }
}
