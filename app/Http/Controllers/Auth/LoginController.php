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
        if (Auth::check() && Auth()->user()->role == 0) {
            return redirect()->route('home.user');
        } else if (Auth::check() && Auth()->user()->role == 1 ) {
            return redirect()->route('home.storekeeper');
        }else if (Auth::check() && Auth()->user()->role == 2) {
            return redirect()->route('verif.index');
        }else if (Auth::check() && Auth()->user()->role == 3) {
            return redirect()->route('home.admin');
        } else if (Auth::check() && Auth()->user()->role == 4) {
            return redirect()->route('home.root');
        }
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
