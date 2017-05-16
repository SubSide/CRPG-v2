<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MySessionsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function show(){
        $sessions = Auth::user()->sessionsDMd()->orderBy('date', 'DESC')->get();
        return view('me.mysessions', compact('sessions'));
    }
}
