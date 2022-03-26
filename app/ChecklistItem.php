<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    public function checklist()
    {
        return $this->hasOne('App\Checklist', 'checklist_id', 'id');
    }
}
