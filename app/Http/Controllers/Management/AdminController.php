<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\AccessLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function show(){
        if(!Auth::user()->hasPermission(AccessLevel::ADMIN))
            return view('home');

        return view('management.home');
    }
}
