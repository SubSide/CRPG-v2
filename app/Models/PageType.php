<?php

namespace App\Models;

class PageType
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
