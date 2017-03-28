<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PlayerlistController extends Controller
{
    public function show(){
        return view('playerlist', array(
            'users' => User::all()
        ));
    }
}
