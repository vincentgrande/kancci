<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    protected $fillable = ['label', 'isChecked','checklist_id','card_id'];
    protected $table = 'checklistitems';

    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

   /**
    * Get the Checklist that owns the ChecklistItem
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function checklist(): BelongsTo
    {
        return $this->belongsTo(Checklist::class,'id','checklist_id');
    }

    /**
     * Get the Card that owns the ChecklistItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class,'id','card_id');
    }

}
