<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardLabel extends Model
{
    protected $fillable = ['card_id', 'label_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Label()
    {
        return $this->belongsTo('App\Label');
    }
}
