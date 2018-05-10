<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Account;
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
    public function getAllAccountsFromUser($user_id)
    {
        $accounts = Account::accountsFromUser($user_id);
        return view('pages.accounts');
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
