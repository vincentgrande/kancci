<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['message','updated_at', 'card_id', 'created_by'];

    /**
     * @var string[]
     */
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the card associated with the comment
     *
     * @return BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

    /**
     * Get the creator associated with the comment
     *
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }
}
