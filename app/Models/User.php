<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    private $_xpUsed;

    public function getNameFormatted(){
        $color = '#BBBBBB';
        switch($this->access_level){
            //default:
            case AccessLevel::WEBMASTER:
            case AccessLevel::ADMIN:
                $color = '#BB8888';
                break;
        }
        return '<a href="/user/'.$this->username.'" style="color: '.$color.'">'.$this->fullname.'</a>';
    }

    public function maxXp(){
        return $this->sessionsPlayed->count() + $this->addon_xp;
    }

    public function xpUsed(){
        if(!isset($_xpUsed))
            $_xpUsed = DB::select('select ROUND(SUM(level * (level + 1) / 2 - 1),0) as total from characters where user_id = ?', [$this->id])[0]->total;

        return $_xpUsed;
    }

    public function hasPermission($permissionLevel){
        return $this->access_level >= $permissionLevel;
    }


    public function sessionsPlayed(){
        return $this->belongsToMany('App\Models\Session', 'session_participants', 'user_id', 'session_id');
    }

    public function sessionsDMd(){
        return $this->hasMany('App\Models\Session', 'dungeon_master');
    }

    public function characters(){
        return $this->hasMany('App\Models\Character');
    }


}
