<?php

namespace App\Models;

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
        'username', 'fullname', 'verify_code', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];





    public function getNameFormatted(){
        $color = '#BBBBBB';
        switch($this->accessLevel){
            //default:
            case AccessLevel::WEBMASTER:
            case AccessLevel::ADMIN:
                $color = '#BB8888';
                break;
        }
        return '<a href="/user/'.$this->username.'" style="color: '.$color.'">'.$this->fullname.'</a>';
    }

    public function hasPermission($permissionLevel){
        return $this->accessLevel >= $permissionLevel;
    }
}
