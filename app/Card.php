<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['uid','title','isActive','table_id'];
    public function tables()
    {
        return $this->hasOne('App\Table', 'id', 'table_id');
    }
}
