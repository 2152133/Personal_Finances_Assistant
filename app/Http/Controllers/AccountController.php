<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\EditUserProfileRequest;
use App\Http\Requests\ChangeUserPasswordRequest;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create()
    {
        $account = new Account;
        return view('accounts.createAccount', compact('account'));
    }


    public function listAllAccouts()
    {
        $accounts = Account::withTrashed()
            ->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
            ->where('owner_id', '=', Auth::user()->id)
            ->select('accounts.*','account_types.name')
            ->get();
        
        return view('accounts.listAllAccounts', compact('accounts'));
    }

    public function edit (Account $account){

        $account_types = DB::table('account_types')
                        ->select('account_types.*')
                        ->get();
        
       
        return view('accounts.editAccounts', compact('account', 'account_types'));
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

    public function store (Request $request){
        
        if ($request->has('cancel')) {
            return redirect()->action('DashboardController@index');
        }

        
        
        $account = $request->validate([
            'account_type_id' => 'required',
            'date' => 'required',
            'code' => 'required',
            'start_balance' => 'required',
            'description' => 'required',
            ]);
        
        DB::table('accounts')->insert([
            ['owner_id' => Auth::user()->id, 
             'account_type_id' => $request->account_type_id,
             'date' => $request->date, 
             'code' => $request->code,
             'start_balance' => $request->start_balance, 
             'description' => $request->description,
            ]
        ]);
        
        return redirect()->action('DashboardController@index');
    }

    public function updateAccount (Request $request, $id){
        
        if ($request->has('cancel')) {
            return redirect()->action('DashboardController@index');
        }

        
        
        $account = $request->validate([
            'account_type_id' => 'required',
            'code' => 'required',
            'start_balance' => 'required',
            'description' => 'required',
            ]);
    

        $accountModel = Account::findOrFail($id);
        $accountModel->fill($account);
        $accountModel->save();
            
        return redirect()->action('DashboardController@index');
    }

    public function delete($id)
    {
        $account = Account::find($id);
        $account->forceDelete();
        
        return redirect()->action('DashboardController@index');
    }
}
