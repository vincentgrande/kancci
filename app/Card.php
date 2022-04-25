<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['title', 'description',  'startDate', 'endDate', 'isActive', 'updated_at','board_id', 'created_by', 'checklist_id'];

    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    /**
     * Get the board that owns the Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class,'board_id','id');
    }

    /**
     * Get the creator that owns the Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class,'id','created_by');
    }

    /**
     * Get the labels owned by the Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
    public function card_label()
    {
        return $this->hasMany('App\CardLabel');
    }
    /**
     * Get the comments owned by the Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the attachments owned by the Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachement::class);
    }

    /**
     * Get the checklist owned by the Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function checklist()
    {
        return $this->hasOne(Checklist::class, 'id','checklist_id');
    }

    public function card_user()
    {
        return $this->hasMany('App\CardUser');
    }
}
