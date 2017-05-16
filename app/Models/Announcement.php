<?php

namespace App\Models;

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
}
