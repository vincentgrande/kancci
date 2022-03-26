<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['uid','title','isActive','board_id','label_id'];

    public function tables()
    {
        return $this->hasOne('App\Board', 'id', 'board_id');
    }
    public function labels()
    {
        return $this->hasMany(Label::class);
    }
    public function checklist()
    {
        return $this->hasOne('App\Checklist', 'checklist_id', 'id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
