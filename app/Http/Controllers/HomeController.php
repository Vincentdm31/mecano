<?php

namespace App\Http\Controllers;


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
        return view('home.user');
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
