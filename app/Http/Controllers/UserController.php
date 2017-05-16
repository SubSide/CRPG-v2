<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view($user){
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
