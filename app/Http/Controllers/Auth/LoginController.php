<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    protected function authenticated()
    {
        if (Auth::check() && Auth()->user()->is_admin == 0){ // do your magic here
            return redirect()->route('home.user');
        }
        else if (Auth::check() && Auth()->user()->is_admin == 1){ // do your magic here
            return redirect()->route('home.storekeeper');
        }
        else if (Auth::check() && Auth()->user()->is_admin == 2){ // do your magic here
            return redirect()->route('home.admin');
        }
        else if (Auth::check() && Auth()->user()->is_admin == 3){ // do your magic here
            return redirect()->route('home.root');
        }

        return redirect('/');
    }
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
        $this->middleware('guest')->except('logout');
    }
}
