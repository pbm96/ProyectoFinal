<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/');
    }

    public function about()
    {
        return view('/about');
    }

    public function contact()
    {
        return view('/contact');
    }

    public function mapaweb()
    {
        return view('/MapaWeb');
    }
}
