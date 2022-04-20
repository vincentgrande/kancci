<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardUser extends Model
{
    protected $fillable = ['user_id', 'card_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}
