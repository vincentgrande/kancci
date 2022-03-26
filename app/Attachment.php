<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function card()
    {
        return $this->hasOne('App\Card', 'id', 'card_id');
    }
}
