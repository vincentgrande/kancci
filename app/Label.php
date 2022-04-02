<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['id','label','color', 'updated_at', 'created_by','board_id', 'card_id'];
    protected $cast = [
      'created_at' => 'datetime',
      'updated_at' => 'datetime'
    ];

    public function Board()
    {
        return $this->hasMany(Board::class);
    }
    public function Card()
    {
        return $this->hasOne(Card::class);
    }
    public function creator()
    {
        return $this->hasOne(User::class);
    }
}
