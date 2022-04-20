<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'email', 'password', 'updated_at', 'reset_token'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function board()
    {
        return $this->hasMany(Board::class);
    }

    /**
     * Get the workgroup associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function workgroup()
    {
        return $this->belongsToMany(WorkGroup::class);
    }
    public function workgroup_user()
    {
        return $this->hasMany('App\WorkGroupUser');
    }
    public function card_user()
    {
        return $this->hasMany('App\CardUser');
    }
}
