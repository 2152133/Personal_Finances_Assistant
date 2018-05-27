<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class MovementController extends Controller
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

    public function listAllMovements($account){

        $movements = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $account)
                    ->select('movements.*')
                    ->get();
    	
    	return view('movements.listAllMovements', compact('movements', 'account'));
    }

    public function create($account)
    {
        $movement = new Movement;
        return view('movements.createMovement', compact('movement', 'account'));
    }

    public function store(Request $request, $account)
    {
        if ($request->has('cancel')) {
            return redirect()->action('DashboardController@index');
        }

        
        $movement = $request->validate([
            'type' => 'required',
            'movement_category_id' => 'required',
            'date' => 'required',
            'value' => 'nullable',
            'description' => 'nullable',
            ]);
        $movement['account_id'] = $account;
        $movement['start_balance'] = 0;
        $movement['end_balance'] = 0;
        
        
        Movement::create($movement);
        
        return redirect()->action('DashboardController@index');
    }

    public function edit (Movement $movement){
               
        return view('movements.editMovement', compact('movement'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('cancel')) {
            return redirect()->action('DashboardController@index');
        }

        
        
        $movement = $request->validate([
            'type' => 'required',
            'date' => 'required',
            'value' => 'required',
            ]);
    

        $movementModel = Movement::findOrFail($id);
        $movementModel->fill($movement);
        $movementModel->save();
            
        return redirect()->action('DashboardController@index');
    }

    public function delete($id)
    {
        $movement = Movement::find($id);
        $movement->delete();
        
        return redirect()->action('DashboardController@index');
    }
}
