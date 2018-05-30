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

    public function index(Request $request){
		$users = User::All();

		$name = $request->input('name');
		$admin = $request->input('admin');
		$blocked = $request->input('blocked');

		$users = User::where('name','like','%'.$name.'%')
			->where('admin','like','%'.$admin.'%')
			->where('blocked','like','%'.$blocked.'%')
	        ->orderBy('name')
	        ->paginate(15);

		return view('users.listUsers', compact('users'));
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
     
        $users = User::where('name','like','%'.$search.'%')
            ->orderBy('name')
            ->paginate(15);
           
        return view('users.list',compact('users'));
	}	

    public function listProfiles()
    {
        $users = User::All();
        $name = \Request::query('name');

        $users = User::where('name','like','%'.$name.'%')
            ->orderBy('name')
            ->paginate(15);

        return view('users.listProfiles', compact('users'));
    }

    public function editProfile(User $user)
    {
        $user = Auth::user();
        $user->can('update');
        return view('users.editProfile', compact('user'));
    }

    public function updateProfile(EditUserProfileRequest $request)
    {
        $user = Auth::user();
        $user->can('update');
        $data = $request->validated();

        

        $user->fill($data);
        $user->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Profile edited successfully.');
    }

	public function editPassword()
    {
        $user = Auth::user();
        return view('users.editPassword', compact('user'));
    }

    public function updatePassword(ChangeUserPasswordRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Password changed successfully.');
    }

    public function listAssociateOf()
    {
        $users = User::all();
        return view('users.listAssociateOf', compact('users'));
    }

    public function listAssociates()
    {
        $users = User::all();
        return view('users.listAssociates', compact('users'));
    }
}
