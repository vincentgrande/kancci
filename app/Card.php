<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Card extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'description',  'startDate', 'endDate', 'isActive', 'updated_at','board_id', 'created_by', 'checklist_id'];

    /**
     * @var string[]
     */
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    /**
     * Get the board that owns the Card
     *
     * @return BelongsTo
     */
    public function board()
    {
        return $this->belongsTo('App\Board');
    }

    /**
     * Get the creator that owns the Card
     *
     * @return BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the labels owned by the Card
     *
     * @return BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany('App\Label');
    }

    /**
     * Get the cards labels owned by the Card
     *
     * @return HasMany
     */
    public function card_label()
    {
        return $this->hasMany('App\CardLabel');
    }
    /**
     * Get the comments owned by the Card
     *
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the attachments owned by the Card
     *
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany('App\Attachement');
    }

    /**
     * Get the checklist owned by the Card
     *
     * @return HasOne
     */
    public function checklist()
    {
        return $this->hasOne('App\Checklist');
    }

    /**
     * Get the users belongs to a card
     *
     * @return HasMany
     */
    public function card_user()
    {
        return $this->hasMany('App\CardUser');
    }
}
