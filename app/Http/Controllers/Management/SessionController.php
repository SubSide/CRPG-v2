<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function viewList(){
        $zoekt = Session::where('dungeon_master', 1)->where('date', '<', 'CURRENT_DATE()')->first();
        if($zoekt != null){
            $zoekt->date = date("Y-m-d H:i:s", strtotime('next tuesday 19:30'));
            $zoekt->save();
        }

        $sessions = Session::where('date', '>', 'CURRENT_DATE()')->orderBy('date', 'DESC')->get();

        $thisWeek = array();
        $nextWeek = array();
        $future = array();

        foreach($sessions as $session){
            if($session->date > date("Y-m-d H:i:s", strtotime('next monday +1 week'))) {
                $future[] = $session;
            } else if($session->date > date("Y-m-d H:i:s", strtotime('next monday'))){
                $nextWeek[] = $session;
            } else {
                $thisWeek[] = $session;
            }
        }
        return view('sessionlist', compact(['thisWeek', 'nextWeek', 'future']));
    }

    public function view($id){
        try {
            $session = Session::findOrFail($id);
            return view('session', compact('session'));
        } catch(ModelNotFoundException $e){
            return redirect(route('sessions'));
        }
    }

    public function create(Request $request){
        if(!Auth::check()){
            return redirect(route('sessions'));
        }

        if($request->isMethod('get')){
            return view('management.session.create');
        }

        $this->validate($request, [
            'title' => 'required|max:32',
            'date' => 'required|date',
            'time' => 'required|regex:/[0-9]{2}\:[0-9]{2}/',
            'prologue' => 'required',
            'approxtime' => 'required|regex:/[0-9]{2}\:[0-9]{2}/',
            'gametype' => 'required|max:16',
            'maxplayers' => 'required|numeric|max:999',
            'round' => 'required|max:16',
        ]);


        $title = strip_tags($_POST['title']);
        $date = date("Y-m-d H:i:s", strtotime($_POST['date'].' '.$_POST['time']));
        $prologue = strip_tags($_POST['prologue']);
        $gameType = $_POST['gametype'];
        $maxPlayers = intval($_POST['maxplayers']);
        $round = $_POST['round'];
        $approxTime = $_POST['approxtime'];

        $session = new Session();
        $session->title = $title;
        $session->date = $date;
        $session->prologue = $prologue;
        $session->gameType = $gameType;
        $session->max_players = $maxPlayers;
        $session->round = $round;
        $session->approx_time = $approxTime;
        $session->dungeonMaster()->associate(Auth::user());
        $session->save();

        return redirect(route('session', ['id' => $session->id]));
    }



    public function edit(Request $request, $id){
        try {
            $session = Session::findOrFail($id);
        } catch(ModelNotFoundException $e){
            return redirect(route('sessions'));
        }

        if(!Auth::check() || (!Auth::user()->hasPermission(\App\Models\AccessLevel::ADMIN) && $session->dungeonMaster != Auth::user())){
            return redirect(route('session', ['id' => $id]))->with('err', 'Je hebt hier geen rechten voor!');
        }

        if($request->isMethod('get')){
            return view('management.session.edit', compact('session'));
        }

        $this->validate($request, [
            'title' => 'required|max:32',
            'date' => 'required|date',
            'time' => 'required|regex:/[0-9]{2}\:[0-9]{2}/',
            'prologue' => 'required',
            'approxtime' => 'required|regex:/[0-9]{2}\:[0-9]{2}/',
            'gametype' => 'required|max:16',
            'maxplayers' => 'required|numeric|max:999',
            'round' => 'required|max:16',
        ]);


        $title = strip_tags($_POST['title']);
        $date = date("Y-m-d H:i:s", strtotime($_POST['date'].' '.$_POST['time']));
        $prologue = strip_tags($_POST['prologue']);
        $gameType = $_POST['gametype'];
        $maxPlayers = intval($_POST['maxplayers']);
        $round = $_POST['round'];
        $approxTime = $_POST['approxtime'];

        $session->title = $title;
        $session->date = $date;
        $session->prologue = $prologue;
        $session->gameType = $gameType;
        $session->max_players = $maxPlayers;
        $session->round = $round;
        $session->approx_time = $approxTime;
        $session->save();

        return redirect(route('session', ['id' => $session->id]));
    }

    public function delete(Request $request, $id){
        try {
            $session = Session::findOrFail($id);
        } catch(ModelNotFoundException $e){
            return redirect(route('sessions'));
        }

        if(!Auth::check() || (!Auth::user()->hasPermission(\App\Models\AccessLevel::ADMIN) && $session->dungeonMaster != Auth::user())){
            return redirect(route('session', ['id' => $id]))->with('err', 'Je hebt hier geen rechten voor!');
        }

        if($request->isMethod('get')){
            return view('session.delete', compact('session'));
        }

        $session->delete();
        return redirect(route('sessions'));
    }

    public function signin($id){
        if(!Auth::check()){
            return redirect(route('session', ['id' => $id]))->with('err', 'Je moet wel ingelogd zijn!');
        }

        try {
            $session = Session::findOrFail($id);


            if ($session->players->contains(Auth::user()->id)){
                return redirect(route('session', ['id' => $id]))->with('err', 'Je doet al mee!');
            } elseif($session->dungeonMaster == Auth::user()){
                return redirect(route('session', ['id' => $id]))->with('err', 'Je bent de dungeon master!');
            } elseif($session->max_players <= $session->players->count()){
                return redirect(route('session', ['id' => $id]))->with('err', 'Deze sessie zit al vol!');
            }

            $session->players()->attach(Auth::user());
            return redirect(route('session', ['id' => $id]));
        } catch(ModelNotFoundException $e){
            return redirect(route('session', ['id' => $id]));
        }
    }

    public function signout($id){
        if(!Auth::check()){
            return redirect(route('session', ['id' => $id]))->with('err', 'Je moet wel ingelogd zijn!');
        }

        try {
            $session = Session::findOrFail($id);
            $session->players()->detach(Auth::user());
            return redirect(route('session', ['id' => $id]));
        } catch(ModelNotFoundException $e){
            return redirect(route('session', ['id' => $id]));
        }
    }
}
