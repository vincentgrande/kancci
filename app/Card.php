<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['id','title', 'description', 'orderNo', 'startDate', 'endDate', 'isActive', 'updated_at','board_id', 'created_by','labels', 'comments', 'attachement_id', 'checklist_id'];
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function board()
    {
        return $this->hasOne(Board::class);
    }
    public function creator()
    {
        return $this->hasOne(User::class);
    }
    public function labels()
    {
        return $this->hasMany(Labels::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function attachment()
    {
        return $this->hasOne(Attachement::class);
    }
    public function checklist()
    {
        return $this->hasOne(Checklist::class);
    }
}
