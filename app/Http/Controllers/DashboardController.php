<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function informasi()
    {
        return view('informasi');
    }

    public function dashboard()
    {
        $user = Auth::user();
        return view('auth.dashboard.dashboard', ['user' => $user]);
    }
    public function app()
    {
        return view("auth.layout.app");
    }
    public function header()
    {
        return view("auth.layout.header");
    }
    public function sidebar(){
        return view("auth.layout.sidebar");
    }
    public function footer(){
        return view("auth.layout.footer");
    }
    public function tambahAgent(){
        return view("auth.dashboard.addAgent.tambahAgent");
    }

}
