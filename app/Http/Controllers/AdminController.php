<?php

namespace App\Http\Controllers;

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

        return view('admin.home');
    }

    public function users(){
        if(!Auth::user()->hasPermission(AccessLevel::ADMIN))
            return view('home');

        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function editUser(Request $request, $user){
        if(!Auth::user()->hasPermission(AccessLevel::ADMIN))
            return view('home');

        try {
            $user = User::where('username', $user)->firstOrFail();
        } catch(ModelNotFoundException $e) {
            return redirect(route('admin.users'));
        }


        if($request->isMethod('get'))
            return view('admin.edituser', compact('user'));

        if($user->accessLevel > Auth::user()->accessLevel) {
            return view('admin.edituser', compact('user'));
        }

        $this->validate($request, [
            'username' => 'required|max:255|',
            'email' => 'required|email|max:255',
            'fullname' => 'required|max:255',
            'accesslevel' => 'required|integer',
        ]);

        $testUser = User::where('username', $request->input('username'))->orWhere('email', $request->input('email'))->get();
        if(count($testUser) > 1 || (!$testUser->contains($user->id) && count($testUser) > 0))
            return redirect(route('admin.users.edit', ['user' => $user->username]))->with('msg', 'Deze username of email bestaat al!');

        $user->username = strip_tags(trim($request->input('username')));
        $user->fullName = strip_tags(trim($request->input('fullname')));
        $user->email = trim($request->input('email'));
        $user->verified = !empty($request->input('verified'));
        if(intval($request->input('accesslevel')) < Auth::user()->accessLevel){
            $user->accessLevel = intval($request->input('accesslevel'));
        }
        $user->save();
        return redirect(route('admin.users.edit', ['user' => $user->username]))->with('msg', 'Gebruiker succesvol aangepast.');
    }
}
