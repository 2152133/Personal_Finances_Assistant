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
        'name', 'admin', 'blocked', 'email', 'password', 'phone', 'profile_photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function type()
    {
        switch ($this->admin) {
            case 0:
                return 'User';
            case 1:
                return 'Admin';
        }

        return 'Unknown';
    }

    public function status()
    {
        switch ($this->blocked) {
            case 0:
                return 'Unblock';
            case 1:
                return 'Block';
        }

        return 'Unknown';
    }

    public function buttonType(){
        switch ($this->admin) {
            case 0:
                return 'Promote Admin';
            case 1:
                return 'Demote User';
        }

        return 'Unknown';
    }

    public function buttonStatus(){
        switch ($this->blocked) {
            case 0:
                return 'Block';
            case 1:
                return 'Unblock';
        }

        return 'Unknown';
    }

}
