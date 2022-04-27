<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistItem extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['label', 'isChecked','checklist_id','card_id'];
    /**
     * @var string
     */
    protected $table = 'checklistitems';
    /**
     * @var string[]
     */
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

   /**
    * Get the Checklist that owns the ChecklistItem
    *
    * @return BelongsTo
    */
    public function checklist()
    {
        return $this->belongsTo('App\Checklist');
    }

    /**
     * Get the Card that owns the ChecklistItem
     *
     * @return BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Card');
    }

}
