<?php

namespace App\Models;

use App\Extensions\BBCode;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getDatePostedFormatted(){
        $days = array('Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag');
        $day = $days[date('N', strtotime($this->date_posted))-1];
        return $day.' '.date( 'd F Y H:i:s', strtotime($this->date_posted));
    }

    public function getTitleUrl(){
        return route('announcement.show', ['id' => $this->id.'-'.str_replace('+', '-', urlencode(preg_replace("/[^a-zA-Z0-9\\ ]+/", "", $this->title)))]);
    }

    public function processedContent(){
        return (new BBCode())->toHTML(strip_tags($this->content));
    }
}
