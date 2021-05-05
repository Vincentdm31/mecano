<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::check() && Auth()->user()->role == 4) {
            return redirect()->route('verif.index');
        } else if (Auth::check() && Auth()->user()->role == 0 ) {
            return redirect()->route('home.user');
        }else if (Auth::check() && Auth()->user()->role == 1) {
            return redirect()->route('home.storekeeper');
        }else if (Auth::check() && Auth()->user()->role == 2) {
            return redirect()->route('home.admin');
        } else if (Auth::check() && Auth()->user()->role == 3) {
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

    public function factureView()
    {
        return view('home.facture');
    }
}
