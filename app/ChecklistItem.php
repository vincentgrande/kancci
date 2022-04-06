<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $fillable = ['label', 'is_checked','checklist_id','card_id'];

    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

   /**
    * Get the Checklist that owns the ChecklistItem
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function Checklist(): BelongsTo
    {
        return $this->belongsTo(Checklist::class);
    }

    /**
     * Get the Card that owns the ChecklistItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

}
