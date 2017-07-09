<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    const LEVEL_RANGES = [
        [1, 2],
        [2, 4],
        [5, 7],
        [8, 10],
        [11, 14],
        [15, 17],
        [18, 20],
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function sessions(){
        return $this->belongsToMany('App\Models\Session', 'session_participants', 'character_id', 'session_id');
    }

    public function getTitleUrl(){
        return route('character', ['id' => $this->id.'-'.str_replace('+', '-', urlencode(preg_replace("/[^a-zA-Z0-9\\ ]+/", "", $this->name)))]);
    }


    // Static functions
    public static function getMaxLevel($xp){
        return floor(sqrt(2 * $xp + 2.25) - 0.5);
    }

    public static function getLevelXp($level){
        return floor(($level * ($level + 1)) / 2 - 1);
    }
}
