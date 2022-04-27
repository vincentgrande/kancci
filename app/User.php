<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'picture', 'updated_at', 'reset_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'reset_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the board associated with the User
     *
     * @return HasMany
     */
    public function board()
    {
        return $this->hasMany('App\Board');
    }

    /**
     * Get the workgroup associated with the User
     *
     * @return belongsToMany
     */
    public function workgroup()
    {
        return $this->belongsToMany('App\WorkGroup');
    }

    /**
     * @return HasMany
     */
    public function workgroup_user()
    {
        return $this->hasMany('App\WorkGroupUser');
    }

    /**
     * @return HasMany
     */
    public function card_user()
    {
        return $this->hasMany('App\CardUser');
    }

    /**
     * @return HasMany
     */
    public function kanbanUser()
    {
        return $this->hasMany('App\KanbanUser');
    }
}
