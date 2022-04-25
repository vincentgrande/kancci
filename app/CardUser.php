<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardUser extends Model
{
    protected $fillable = ['user_id', 'card_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}
