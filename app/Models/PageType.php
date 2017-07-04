<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageType extends Model
{
    const PAGE = 1;
    const RESOURCE = 2;

    public static function getString($type){
        switch($type){
            case PageType::PAGE:
                return 'Page';
            case PageType::RESOURCE:
                return 'Resource';
        }
        return 'ERROR';
    }
}
