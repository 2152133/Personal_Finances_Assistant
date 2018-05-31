<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Account;
use App\Movement;
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

        return redirect()->action('DashboardController@index', Auth::user());
    }

    public function reopen($id)
    {
        $account = Account::withTrashed()
                ->where('id', '=', $id)
                ->restore();

        return redirect()->action('DashboardController@index', Auth::user());
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
            return redirect()->action('DashboardController@index', Auth::user());
        }
        
        $account = $request->validate([
            'account_type_id' => 'required|integer|min:1|max:5',
            'date' => 'nullable|date',
            'code' => 'required|unique:acounts',
            'start_balance' => 'required|integer',
            'description' => 'nullable|string',
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
        
        return redirect()->action('DashboardController@index', Auth::user());
    }

    public function updateAccount (Request $request, $id){
        
        if ($request->has('cancel')) {
            return redirect()->action('DashboardController@index', Auth::user());
        }

        if ($request->filled('start_balance')) {
            $movements = Account::join('movements', 'movements.account_id', '=', 'accounts.id')
                        ->where('movements.account_id', '=', $id)
                        ->select('movements.*')
                        ->orderBy('movements.id', 'asc')
                        ->get();

        }

        $accountCode = Account::findOrFail($id);

        $account = $request->validate([
            'account_type_id' => 'required|max:5|integer',
            'code' => 'required|unique:accounts,code,'.$id,
            'date' => 'required|date',
            'start_balance' => 'required',
            'description' => 'nullable',
            ]);


        if (count($movements)>0) {
            for ($i=0; $i < count($movements); $i++) { 
                if ($i==0) {
                    if ($movements[$i]->type == 'expense') {

                        DB::table('accounts')
                            ->join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $id)
                            ->where('movements.id', '=', $movements[$i]->id)
                            ->update(['movements.start_balance' => $request->start_balance,
                                    'movements.end_balance' => ($request->start_balance - $movements[$i]->value)]);

                    }else{
                         DB::table('accounts')
                            ->join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $id)
                            ->where('movements.id', '=', $movements[$i]->id)
                            ->update(['movements.start_balance' => $request->start_balance,
                                    'movements.end_balance' => ($request->start_balance + $movements[$i]->value)]);

                    }
                    
                }else{

                     $end_balance_movement = Account::join('movements', 'movements.account_id', '=', 'accounts.id')
                                ->where('accounts.id', '=', $id)
                                ->where('movements.id', '=', $movements[($i-1)]->id)
                                ->select('movements.end_balance')
                                ->first();

                     
                        if ($movements[$i]->type == 'expense') {
                            DB::table('accounts')
                                ->join('movements', 'movements.account_id', '=', 'accounts.id')
                                ->where('accounts.id', '=', $id)
                                ->where('movements.id', '=', $movements[$i]->id)
                                ->update(['movements.start_balance' => $end_balance_movement->end_balance,
                                        'movements.end_balance' => ($end_balance_movement->end_balance - $movements[$i]->value) ]);
                            

                        }else{
                            DB::table('accounts')
                                ->join('movements', 'movements.account_id', '=', 'accounts.id')
                                ->where('accounts.id', '=', $id)
                                ->where('movements.id', '=', $movements[$i]->id)
                                ->update(['movements.start_balance' => $end_balance_movement->end_balance,
                                        'movements.end_balance' => ($end_balance_movement->end_balance + $movements[$i]->value)]);
                        }
                }

                if ($i == (count($movements))-1) {
                    $lastMovementId = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $id)
                    ->max('movements.id');

                    $lastMovement = Movement::findOrFail($lastMovementId);
                   $current_balance=$lastMovement->end_balance;
                }
                
            }
            DB::table('accounts')
                ->where('accounts.id', '=', $id)
                ->update(['accounts.current_balance' => $current_balance]);
        }

        $accountModel = Account::findOrFail($id);
        $accountModel->fill($account);
        $accountModel->save();
            
        return redirect()->action('DashboardController@index', Auth::user());
    }

    public function delete($id)
    {
        $account = Account::find($id);

        $movements = Account::join('movements', 'movements.account_id', '=', 'accounts.id')
                    ->where('accounts.id', '=', $id)
                    ->get();

        if (count($movements) == 0) {
            $account->forceDelete();
        }else{
             return redirect()->action('DashboardController@index', Auth::user());
        }
        
        
        return redirect()->action('DashboardController@index', Auth::user());
    }
}
