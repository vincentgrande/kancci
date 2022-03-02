<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function tables()
    { 
        return $this->hasOne('App\Table', 'id', 'table_id'); 
    }
}
