<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    }

    public function userView()
    {
        return view('home.user');
    }

    public function storeKeeperView()
    {
        return view('home.storekeeper');
    }

    public function adminView()
    {
        return view('home.admin');
    }

    public function rootView()
    {
        return view('home.root');
    }
}
