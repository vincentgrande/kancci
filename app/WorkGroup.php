<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WorkGroup extends Model
{
    protected $fillable = ['title', 'updated_at', 'created_by', 'users', 'kanban_id'];
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];
    public function creator()
    {
        return $this->hasOne(User::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function kanban()
    {
        return $this->hasMany(Kanban::class);
    }
}
