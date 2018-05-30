<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

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
    public function index(User $user)
    {
    	$totalBalance = DB::table('accounts')->where('owner_id', $user)->sum('current_balance');
    	$userAccounts = DB::table('accounts')->where('owner_id', $user)->get();
    	
        return view('pages.dashboard',['user' => Auth::user()], compact('totalBalance', 'userAccounts', 'accountPercentages'));
    }
}
