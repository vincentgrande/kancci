<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    public function card()
    {
        return $this->hasOne('App\Card', 'id', 'checklist_id');
    }
    public function checklistitems()
    {
        return $this->belongsToMany(ChecklistItem::class);
    }
}
