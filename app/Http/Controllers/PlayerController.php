<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{


    public function viewList(){

        /* Last played session */

        $allLastPlayed = DB::select(
            "SELECT session_participants.user_id, sessions.id, sessions.title FROM session_participants
            LEFT JOIN (
                SELECT session_participants.user_id, max(sessions.date) AS date FROM session_participants
                JOIN sessions ON session_participants.session_id=sessions.id
                WHERE sessions.date < CURRENT_DATE()
                GROUP BY session_participants.user_id
            ) latest ON latest.user_id=session_participants.user_id
            JOIN sessions ON session_participants.session_id=sessions.id AND latest.date=sessions.date
            GROUP BY session_participants.user_id, sessions.id, sessions.title"
        );

        $lastPlayed = array();
        foreach($allLastPlayed as $singleLastPlayed){
            $lastPlayed[$singleLastPlayed->user_id] = array($singleLastPlayed->id, $singleLastPlayed->title);
        }
        /* End last played session */



        /* Upcoming sessions */
        $allNextPlaying = DB::select(
            "SELECT session_participants.user_id, sessions.id, sessions.title FROM session_participants
            LEFT JOIN (
                SELECT session_participants.user_id, min(sessions.date) AS date FROM session_participants
                JOIN sessions ON session_participants.session_id=sessions.id
                WHERE sessions.date >= CURRENT_DATE() AND sessions.dungeon_master != 1
                GROUP BY session_participants.user_id
            ) latest ON latest.user_id=session_participants.user_id
            JOIN sessions ON session_participants.session_id=sessions.id AND latest.date=sessions.date
            GROUP BY session_participants.user_id, sessions.id, sessions.title"
        );

        $nextPlaying = array();
        foreach($allNextPlaying as $singleNextPlaying){
            $nextPlaying[$singleNextPlaying->user_id] = array($singleNextPlaying->id, $singleNextPlaying->title);
        }
        /* Upcoming sessions */

        return view('playerlist', array(
            'users' => User::orderBy('fullname', 'ASC')->get(),
            'lastPlayed'=>$lastPlayed,
            'nextPlaying'=>$nextPlaying
        ));
    }

    public function viewProfile($user){
        try {
            $user = User::where('username', $user)->firstOrFail();

            $sessionsPlayed = $user->sessionsPlayed()->get();
            $sessionsDMd = $user->sessionsDMd()->get();

            return view('user', compact('user', 'sessionsPlayed', 'sessionsDMd'));
        } catch(ModelNotFoundException $e){
            return redirect(route('playerlist'));
        }
    }
}
