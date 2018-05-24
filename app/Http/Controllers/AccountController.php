<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function listAllAccouts()
    {
        $accounts = Account::withTrashed()
            ->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
            ->where('owner_id', '=', Auth::user()->id)
            ->select('accounts.id', 'accounts.code', 'account_types.name', 'accounts.current_balance' )
            ->get();
        
        return view('accounts.listAllAccounts', compact('accounts'));
    }

    public function edit (Account $account){
       
        return view('accounts.editAccounts', compact('account'));
    }


    public function close($id)
    {
        $account = Account::find($id);
        $account->delete();

        return redirect()->action('DashboardController@index');
    }

    public function reopen($id)
    {
        $account = Account::withTrashed()
                ->where('id', '=', $id)
                ->restore();

        return redirect()->action('DashboardController@index');
    }

    public function openedAccounts ($account){
       $accounts = Account::join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
            ->where('owner_id', '=', Auth::user()->id)
            ->select('accounts.id', 'accounts.code', 'account_types.name', 'accounts.current_balance' )
            ->get();

        return view('accounts.openedAccounts', compact('accounts'));
    }

    public function closedAccounts ($account){
       $accounts = Account::onlyTrashed()
            ->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
            ->where('owner_id', '=', Auth::user()->id)
            ->select('accounts.id', 'accounts.code', 'account_types.name', 'accounts.current_balance' )
            ->get();

        return view('accounts.closedAccounts', compact('accounts'));
    }   

}
