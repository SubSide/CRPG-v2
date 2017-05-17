<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PlayerController extends Controller
{


    public function viewList(){
        return view('playerlist', array(
            'users' => User::all()
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
