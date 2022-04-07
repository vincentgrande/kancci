<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardLabel extends Model
{
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

    public function Label()
    {
        return $this->belongsTo('App\Label');
    }
}
