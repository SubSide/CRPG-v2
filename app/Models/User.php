<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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


    public function sessionsPlayed(){
        return $this->belongsToMany('App\Models\Session', 'session_participants', 'user_id', 'session_id');
    }

    public function sessionsDMd(){
        return $this->hasMany('App\Models\Session', 'dungeon_master');
    }


}
