<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the card associated with the Alert
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}
