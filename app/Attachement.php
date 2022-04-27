<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachement extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['original_name', 'filepath', 'uploaded_by', 'card_id'];
    /**
     * @var string[]
     */
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the card that owns the Attachment
     *
     * @return BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

    /**
     * Get the creator that owns the Attachment
     *
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }
}
