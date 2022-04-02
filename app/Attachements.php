<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachements extends Model
{
    protected $fillable = ['extension', 'fileName', 'filePath','updated_at', 'uploaded_by', 'card_id'];
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
