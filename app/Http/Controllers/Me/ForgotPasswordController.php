<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPassword(Request $request){
        if($request->isMethod('get'))
            return view('me.forgotpassword');

        $this->validate($request, [
            'email' => 'required|email|max:255',
        ]);
        DB::delete('DELETE FROM password_resets WHERE created_at<:date_created', [
            'date_created' => date("Y-m-d H:i:s", strtotime('-2 hours'))
        ]);

        $result = DB::select('SELECT * FROM password_resets WHERE email=:email', [
            'email' => $request->input('email')
        ]);

        if(count($result) > 0){
            return view('me.forgotpassword', [
                'message' => 'Voor dit email adres is recentelijk al een nieuw wachtwoord aangevraagd. Wacht een tijdje of vraag om hulp in de Whatsapp groep.'
            ]);
        }

        $token = bin2hex(random_bytes(32));

        DB::insert('INSERT INTO password_resets(email, token, created_at) VALUES(:email, :token, :created_at)', [
            'email' => $request->input('email'),
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        try {
            $user = User::where('email', $request->input('email'))->firstOrFail();
            //Mail::to($user->email)->send(new ForgotPassword($user));
        } catch(ModelNotFoundException $e){}

        return view('me.forgotpassword', [
            'message' => 'Al zit er aan dit email een account gekoppeld, dan is er een mail gestuurd met een link om je wachtwoord te resetten.'
        ]);
    }

    public function reset(Request $request){

    }
}
