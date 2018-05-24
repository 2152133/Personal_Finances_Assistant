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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$user = Auth::user();
        $user->can('create');

        $account = new Account;
        return view('accounts.create', compact('account'));
    }

    public function listAllAccouts()
    {
        //$accounts = DB::table('accounts')
        //    ->where('id', Auth::user()->id);
        $accounts = Account::where('owner_id', '=', Auth::user()->id)->get();
        return view('accounts.listAllAccounts', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
