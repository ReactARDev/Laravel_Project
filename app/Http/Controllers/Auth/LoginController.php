<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use \App\User;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function validateLogin($request)
    {
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required'
            // $this->username() => 'required', 'password' => 'required', 'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'));
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        // $forceCredential = ['name'=> 'Siolio', 'password'=>'34223422'];
        // $forceCredential = ['name'=> 'anton9050', 'password'=>'anton9050'];
        if (Auth::guard()->attempt($this->credentials($request))) {
        // if (Auth::guard()->attempt($forceCredential)) {
            //authentication passed
            $user = User::find(Auth::id());
            if ($user->ban == 1) {
                $this->guard()->logout();
                return redirect()->back()->with('error', 'You have been banned from participating on this website. Please use the contact form for more information or contact the moderators on /r/SoccerStreams.');
            } else {
                $this->isRemember($request);
                return redirect('/profile');
            }
        }

        return redirect()->back()->with('error', 'These credentials do not match our records.');
    }

    public function username()
    {
        return 'name';
    }

    public function isRemember($request){
        if($request->input('remember')){
            //for 30 days
            $time = time() + (86400 * 30);
            $this->cookieSet("name",$request->input('name'),$time);
            $this->cookieSet("password",$request->input('password'),$time);
        }
    }
}
