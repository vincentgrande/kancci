<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Label extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['label','color', 'updated_at', 'created_by'];
    /**
     * @var string[]
     */
    protected $cast = [
      'created_at' => 'datetime',
      'updated_at' => 'datetime'
    ];

    /**
     * Get the board associated with the Label
     *
     * @return BelongsTo
     */
    public function board()
    {
        return $this->belongsTo('App\Board');
    }

    /**
     * Get the cards associated with the Label
     *
     * @return BelongsToMany
     */
    public function cards()
    {
        return $this->belongsToMany('App\Card');
    }

    /**
     * Get the card_label associated with the Label
     * @return HasMany
     */
    public function card_label()
    {
        return $this->hasMany('App\CardLabel');
    }
    /**
     * Get the creator associated with the Label
     *
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the kanban associated with the Label
     *
     * @return HasMany
     */
    public function kanban()
    {
        return $this->hasMany('App\Kanban');
    }

    /**
     * Get the kanban_label associated with the Label
     * @return HasMany
     */
    public function kanban_label()
    {
        return $this->hasMany('App\KanbanLabel');
    }
}
