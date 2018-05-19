<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
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
    public function getAllAccountsFromUser($user)
    {
        $accounts = Account::accountsFromUser($user);
        
        return view('pages.accounts', compact('accounts'));
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
