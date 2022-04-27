<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    protected $fillable = ['card_id', 'user_id', 'is_read'];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return BelongsTo
     */
    public function card() : BelongsTo
    {
        return $this->belongsTo('App\Card');
    }
}
