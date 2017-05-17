<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function settings(Request $request){
        if($request->isMethod('get'))
            return view('me.settings');


        $this->validate($request, [
            'fullname' => 'required|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->fullname = $request->input('fullname');
        if(!empty($request->input('password')))
            $user->password = Hash::make($request->input('password'));

        $user->save();

        return view('me.settings', ['msg' => 'Settings saved!']);
    }
}
