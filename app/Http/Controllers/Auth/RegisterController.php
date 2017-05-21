<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ConfirmEmail;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function view(){
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        // We don't want the user to automatically login.
        //$this->guard()->login($user);

        Mail::to($user)->send(new ConfirmEmail($user));


        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
    public function redirectTo(){
        return route('register.successful');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $reserved = env('RESERVED_URLS','');
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'fullname' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->fullname = $data['fullname'];
        $user->access_level = '0';
        $user->verified = '0';
        $user->password = bcrypt($data['password']);
        $user->verify_code = bin2hex(random_bytes(20));
        $user->date_registered = date("Y-m-d H:i:s");
        $user->registration_ip = $_SERVER['REMOTE_ADDR'];
        $user->save();

        return $user;
    }

    public function registrationSuccesful(){
        return view('auth.registrationsuccesful');
    }

    public function confirm($token){
        try {
            $user = User::where('verify_code', $token)->where('verified', '0')->firstOrFail();
            $user->verified = 1;
            $user->save();
            return view('auth.confirmregistration');
        } catch(ModelNotFoundException $e){
            return view('auth.confirmregistration', [
                'message' => 'De token is incorrect of al gebruikt!'
            ]);
        }
    }
}