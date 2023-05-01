<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Google2FA;
use App\Models\User;

class LoginController extends Controller
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        }
        $this->middleware('guest')->except('logout');
    }

    /**
     * Signing out of session
     * @param  Request $request
     * @return url         redirect url
     */
    public function logout(Request $request)
    {
        if (extension_loaded('imagick') && setting('2fa')) {

            Google2FA::logout();
        }

        Auth::logout();
        return redirect('/');
    }
}
