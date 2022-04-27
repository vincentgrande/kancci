<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardUser extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'card_id'];

    /**
     * Get the user associated with the CardUser
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the card associated with the CardUser
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}
