<?php

namespace App\Models;

use App\Extensions\BBCode;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    public function players(){
        return $this->belongsToMany('App\Models\User', 'session_participants')->withPivot('character_id');
    }

    public function dungeonMaster()
    {
        return $this->belongsTo('App\Models\User', 'dungeon_master');
    }

    public function previousSession()
    {
        return $this->belongsTo('App\Models\Session', 'previous_session');
    }

    public function processedPrologue(){
        return (new BBCode())->toHTML(strip_tags($this->prologue));
    }

    public function getDateFormatted(){
        $text = '<span style="color: ';

        if($this->date < date("Y-m-d H:i:s", strtotime("today"))){
            $text .= '#DD5555';
        } else if($this->date >= date("Y-m-d H:i:s", strtotime('today')) && $this->date <= date("Y-m-d H:i:s", strtotime('tomorrow'))){
            $text .= '#AAAAAA';
        } else {
            $text .= '#55AA55';
        }
        $days = array('Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag');
        $day = $days[date('N', strtotime($this->date))-1];
        return $text . ';">'.$day.' '.date( 'd F Y H:i', strtotime($this->date)).'</span>';
    }


    public function getApproximateTime(){
        $expl = explode(':', $this->approx_time);
        if(count($expl) > 1){
            return $expl[0].':'.$expl[1];
        }
        return '00:00';
    }

    public function getTitleUrl(){
        return route('session', ['id' => $this->id.'-'.str_replace('+', '-', urlencode(preg_replace("/[^a-zA-Z0-9\\ ]+/", "", $this->title)))]);
    }
}
