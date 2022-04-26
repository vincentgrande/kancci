<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'created_by','card_id'];

    /**
     * @var string[]
     */
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get all of the checklistitems for the Checklist
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistitems(): HasMany
    {
        return $this->hasMany(ChecklistItem::class);
    }

    /**
     * Get the card associated with the Checklist
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function card(): HasOne
    {
        return $this->hasOne(Card::class,'id','card_id');
    }

    /**
     * Get the user that owns the Checklist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'id','created_by');
    }
}
