<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Models\Character;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyCharactersController extends Controller
{

    public function viewList(){
        if(!Auth::check()){
            return redirect(route('home'));
        }

        $characters = Auth::user()->characters()->get();
        return view('me.characters.mylist', compact(['characters']));
    }


    public function show($id){
        try {
            $character = Character::findOrFail($id);
            return view('me.characters.view', compact('character'));
        } catch(ModelNotFoundException $e){
            return redirect(route('home'));
        }
    }


    public function create(Request $request){
        if(!Auth::check()){
            return redirect(route('home'));
        }

        if($request->isMethod('get')){
            return view('me.characters.create');
        }

        $this->validate($request, [
            'name' => 'required|max:32',
            'class' => 'required|max:32',
            'gametype' => 'required|max:32',
            'level' => 'required|numeric|max:999',
        ]);


        $name = strip_tags($request->input('name'));
        $class = strip_tags($request->input('class'));
        $gametype = strip_tags($request->input('gametype'));
        $level = intval($request->input('level'));

        $character = new Character();
        $character->name = $name;
        $character->class = $class;
        $character->gametype = $gametype;
        $character->level = $level;

        $character->user()->associate(Auth::user());
        $character->save();

        return redirect(route('character', ['id' => $character->id]));
    }


/*
    public function edit(Request $request, $id){
        try {
            $session = Session::findOrFail($id);
        } catch(ModelNotFoundException $e){
            return redirect(route('sessions'));
        }

        if(!Auth::check() || Auth::user()->cant('update', $session)){
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


        $title = strip_tags($request->input('title'));
        $date = date("Y-m-d H:i:s", strtotime($request->input('date').' '.$request->input('time')));
        $prologue = strip_tags($request->input('prologue'));
        $gameType = $request->input('gametype');
        $maxPlayers = intval($request->input('maxplayers'));
        $round = $request->input('round');
        $approxTime = $request->input('approxtime');

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
*/
/*
    public function delete(Request $request, $id){
        try {
            $session = Session::findOrFail($id);
        } catch(ModelNotFoundException $e){
            return redirect(route('sessions'));
        }

        if(!Auth::check() || Auth::user()->cant('delete', $session)){
            return redirect(route('session', ['id' => $id]))->with('err', 'Je hebt hier geen rechten voor!');
        }

        if($request->isMethod('get')){
            return view('management.session.delete', compact('session'));
        }

        $session->delete();
        return redirect(route('sessions'));
    }
*/
}
