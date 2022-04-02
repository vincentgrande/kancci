<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = ['title', 'checklist_items', 'created_by','card_id'];
    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function CheckListItems()
    {
        return $this->hasMany(ChecklistItem::class);
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
