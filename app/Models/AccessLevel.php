<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLevel {
    const USER = 0;
    const ADMIN = 1;
    const WEBMASTER = 2;

    public static function getLevelFormatted($accessLevel){
        $color = '#BBBBBB';
        $title = 'Player';
        switch($accessLevel){
            //default:
            case AccessLevel::WEBMASTER:
                $color = '#BB8888';
                $title = 'Webmaster';
                break;
            case AccessLevel::ADMIN:
                $color = '#BB8888';
                $title = 'Admin';
                break;
        }
        return '<span style="color: '.$color.'">'.$title.'</span>';
    }
}