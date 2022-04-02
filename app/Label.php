<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    public function card()
    {
        return $this->hasOne('App\Card', 'id', 'label_id');
    }
}
