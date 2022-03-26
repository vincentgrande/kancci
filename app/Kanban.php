<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kanban extends Model
{
    public function tables()
    {
        return $this->hasMany(Board::class);
    }
}
