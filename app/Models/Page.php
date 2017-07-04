<?php

namespace App\Models;

use App\Extensions\BBCode;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function lastEditedBy(){
        return $this->belongsTo('App\Models\User', 'last_edited_by');
    }

    public function getTitleUrl(){
        return route('page', ['id' => $this->id.'-'.str_replace('+', '-', urlencode(preg_replace("/[^a-zA-Z0-9\\ ]+/", "", $this->title)))]);
    }


    public function processedContent(){
        return (new BBCode())->toHTML(strip_tags($this->content));
    }
}
