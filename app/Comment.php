<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['message','updated_at', 'card_id', 'created_by'];
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function Card()
    {
        return $this->hasOne(Card::class);
    }
    public function creator()
    {
        return $this->hasOne(User::class);
    }
}
