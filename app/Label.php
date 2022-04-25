<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['label','color', 'updated_at', 'created_by'];
    protected $cast = [
      'created_at' => 'datetime',
      'updated_at' => 'datetime'
    ];

    /**
     * Get the board associated with the Label
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get the cards associated with the Label
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }
    public function card_label()
    {
        return $this->hasMany('App\CardLabel');
    }
    /**
     * Get the creator associated with the Label
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'id','created_by');
    }

    /**
     * Get the kanban associated with the WorkGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kanban()
    {
        return $this->hasMany(Kanban::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kanban_label()
    {
        return $this->hasMany('App\KanbanLabel');
    }
}
