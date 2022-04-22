<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachement extends Model
{
    protected $fillable = ['original_name', 'filepath', 'uploaded_by', 'card_id'];
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the card that owns the Attachment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo(Card::class,'id','card_id');
    }

    /**
     * Get the creator that owns the Attachment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'id','uploaded_by');
    }
}
