<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
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
    public function getAllAccountsFromUser($user_id)
    {
        $accounts = Account::accountsFromUser($user_id);
        return view('pages.accounts');
    }

    public function listAllAccouts()
    {
        $accounts = DB::table('accounts')
            ->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
            ->where('owner_id', '=', Auth::user()->id)
            ->select('accounts.id', 'accounts.code', 'account_types.name', 'accounts.current_balance' )
            ->get();
        
        return view('accounts.listAllAccounts', compact('accounts'));
    }

    public function edit (Account $account){
       

        return view('accounts.editAccounts', compact('account'));
    }

    public function getAllAccountsStart()
    {
        if(Auth::check()){
            return redirect('accounts/' . Auth::id());
        } else {
            return '/home';
        }
    }
}
