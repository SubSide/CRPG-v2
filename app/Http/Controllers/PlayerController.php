<?php

namespace App\Http\Controllers;

use App\Models\Character;
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

        /* Most played character */
        $allMostPlayedCharacter = DB::select(
            "SELECT sp1.user_id, sp1.character_id FROM session_participants sp1
            WHERE character_id=(
                SELECT sp2.character_id
                FROM session_participants sp2
                WHERE sp2.character_id IS NOT NULL
                AND sp1.user_id=sp2.user_id
                GROUP BY sp2.user_id, sp2.character_id
                ORDER BY COUNT(*) DESC
                LIMIT 1
            )
            GROUP BY user_id, character_id"
        );
        $mostPlayedCharacter = array();
        foreach($allMostPlayedCharacter as $singleMostPlayedCharacter){
            $mostPlayedCharacter[$singleMostPlayedCharacter->user_id] = Character::find($singleMostPlayedCharacter->character_id);
        }
        /* Most played character */


        return view('playerlist', array(
            'users' => User::orderBy('fullname', 'ASC')->get(),
            'lastPlayed'=>$lastPlayed,
            'nextPlaying'=>$nextPlaying,
            'mostPlayedCharacter' => $mostPlayedCharacter,
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
