<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Account;

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
    	$totalBalance = Account::where('owner_id', $user->id)->sum('current_balance');
    	$userAccounts = Account::where('owner_id', $user->id)
                            ->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')
                            ->select('accounts.*','account_types.name')
                            ->get();
        
    	
        return view('pages.dashboard',[Auth::user()], compact('totalBalance', 'userAccounts', 'accountPercentages', 'user'));
    }
}
