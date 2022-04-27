<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardLabel extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['card_id', 'label_id'];

    /**
     * Get the card associated with the CardLabel
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

    /**
     * Get the label associated with the CardLabel
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Label()
    {
        return $this->belongsTo('App\Label');
    }
}
