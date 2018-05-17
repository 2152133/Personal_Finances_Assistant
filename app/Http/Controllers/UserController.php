<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserProfileRequest;
use App\Http\Requests\ChangeUserPasswordRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

     public function listProfiles()
    {
        $users = User::paginate(15);
        return view('user.listProfiles', compact('users'));
    }

    public function editProfile(User $user)
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        return view('user.editProfile', compact('user'));
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
        return view('user.editPassword', compact('user'));
    }

    public function updatePassword(ChangeUserPasswordRequest $request)
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        $data = $request->validated();

        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect()
            ->route('home')
            ->with('success', 'Password changed successfully.');
    }
}
