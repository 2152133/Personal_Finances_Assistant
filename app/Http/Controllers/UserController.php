<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

    public function index(){

		$users = User::All();
		$pagetitle = "List of Users";
		$name = \Request::query('name');
		$admin = \Request::get('admin');
		$blocked = \Request::get('blocked');

		$users = User::where('name','like','%'.$name.'%')
			->where('admin','like','%'.$admin.'%')
			->where('blocked','like','%'.$blocked.'%')
	        ->orderBy('name')
	        ->paginate(20);

		return view('users.list', compact('users', 'pagetitle'));
		//dd($this);

    }

    public function block(User $user){

    	if ($user == Auth::user()) {
    		return redirect()->action('UserController@index')->with(['msgglobal' => 'Impossível bloquear o utilizador atual! ']);
    	}else{
    		DB::table('users')
			->where('id', $user->id)
			->update(['blocked' => 1]);
		
			return redirect()->action('UserController@index');
    	}
		
	}

	public function unblock(User $user){
		if ($user == Auth::user()) {
    		return redirect()->action('UserController@index')->with(['msgglobal' => 'Impossível desbloquear o utilizador atual! ']);
    	}else{
			DB::table('users')
				->where('id', $user->id)
				->update(['blocked' => 0]);
			
			return redirect()->action('UserController@index');
		}
	}

	public function promote(User $user)
	{
		if ($user == Auth::user()) {
    		return redirect()->action('UserController@index')->with(['msgglobal' => 'Impossível promover o utilizador atual! ']);
    	}else{
			DB::table('users')
				->where('id', $user->id)
				->update(['admin' => 1]);
			
			return redirect()->action('UserController@index');
		}
	}

	public function demote(User $user)
	{
		if ($user == Auth::user()) {
    		return redirect()->action('UserController@index')->with(['msgglobal' => 'Impossível despromover o utilizador atual! ']);
    	}else{
			DB::table('users')
				->where('id', $user->id)
				->update(['admin' => 0]);
			
			return redirect()->action('UserController@index');
		}
	}


   public function pesquisar()
   {
	    $search = \Request::get('search'); //<-- we use global request to get the param of URI
	    $pagetitle = "List of Users";
	 
	    $users = User::where('name','like','%'.$search.'%')
	        ->orderBy('name')
	        ->paginate(20);
	 
	    return view('users.list',compact('users', 'pagetitle'));
   }
}
