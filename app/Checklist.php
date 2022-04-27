<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     * @return HasMany
     */
    public function checklistitems()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    /**
     * Get the card associated with the Checklist
     *
     * @return HasOne
     */
    public function card()
    {
        return $this->hasOne('App\Card');
    }

    /**
     * Get the user that owns the Checklist
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
