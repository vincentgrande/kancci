<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['card_id', 'user_id', 'is_read'];

    /**
     * Get the user associated with the Alert
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the card associated with the Alert
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card() : BelongsTo
    {
        return $this->belongsTo('App\Card');
    }
}
