<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    public function checklist()
    {
        return $this->hasOne(Checklist::class);
    }
    public function card()
    {
        return $this->hasOne(Checklist::class);
    }
}
