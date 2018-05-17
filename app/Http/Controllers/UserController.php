<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\EditUserProfileRequest;
use App\Http\Requests\ChangeUserPasswordRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
	        ->paginate(15);

		return view('users.list', compact('users'));
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
	        ->paginate(15);
	 
	    return view('users.list',compact('users', 'pagetitle'));
   }	

     public function listProfiles()
    {
        $users = User::paginate(15);
        return view('users.listProfiles', compact('users'));
    }

    public function editProfile(User $user)
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        return view('users.editProfile', compact('user'));
    }

    public function updateProfile(EditUserProfileRequest $request)
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        $data = $request->validated();

        $user->fill($data);
        $user->save();

        return redirect()
            ->route('home')
            ->with('success', 'Profile edited successfully.');
    }

	public function editPassword()
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        return view('users.editPassword', compact('user'));
    }

    public function updatePassword(ChangeUserPasswordRequest $request)
    {
        $user = Auth::user();
        $this->can('resgisted');

        $data = $request->validated();

        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect()
            ->route('home')
            ->with('success', 'Password changed successfully.');
    }
}
