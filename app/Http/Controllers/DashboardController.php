<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Controllers\Controller;

use Log;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /*public function __construct()
    {
        $this->middleware('admin');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info("DashboardController => index");
        Log::info(Auth::user());
        return view('admin');
    }
}
