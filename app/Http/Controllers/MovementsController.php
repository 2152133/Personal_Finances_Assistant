<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use App\MovementCategory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class MovementsController extends Controller
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

    public function listMovements($account_id){
    	$movements = [];
    	if (Gate::forUser(Auth::user())->allows('view-account-movements', $account_id)) {
    		$movements = Movement::where('account_id', $account_id)->get();

		}
    	
    	return view('pages.listMovements', compact('movements', 'account_id'));
    }

    public function showAddMovementForm($account_id){
        $movement_categories = MovementCategory::all();
    	return view('pages.addMovement', compact('account_id', 'movement_categories'));
    }
}
