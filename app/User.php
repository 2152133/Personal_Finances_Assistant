<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'profile_photo', 'old_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'id',
    ];

    //formatted_type
    public function getFormattedAdminAttribute()
    {
        switch ($this->admin) {
            case 0:
                return 'No';
            case 1:
                return 'Yes';
        }
        return 'Unknown';
    }

    public function getFormattedBlockedAttribute()
    {
        switch ($this->blocked) {
            case 0:
                return 'No';
            case 1:
                return 'Yes';
        }
        return 'Unknown';
    }

    public function isAdmin()
    {
        return $this->admin === '1';
    }

    public function isRegistered()
    {
        return $this->admin === '0';
    }

    public function associatedMembers()
    {
        return $this->belongsToMany('App\User', 'associate_members', 'main_user_id', 'associated_user_id');
    }

    public function associatedTo()
    {
        return $this->belongsToMany('App\User', 'associate_members', 'associated_user_id', 'main_user_id');
    }
}
