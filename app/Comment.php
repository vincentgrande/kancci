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

    /**
     * Get the card associated with the comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function card()
    {
        return $this->belongsTo(Card::class,'id','card_id');
    }

    /**
     * Get the creator associated with the comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->belongsTo(User::class,'id','created_by');
    }
}
