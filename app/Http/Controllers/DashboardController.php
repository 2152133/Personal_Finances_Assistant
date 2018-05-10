<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
    	$totalBalance = DB::table('accounts')->where('owner_id', Auth::user()->id)->sum('current_balance');
    	$userAccounts = DB::table('accounts')->where('owner_id', Auth::user()->id)->get();
    	
        return view('pages.dashboard', compact('totalBalance', 'userAccounts', 'accountPercentages'));
    }
}
