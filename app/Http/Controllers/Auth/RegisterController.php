<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'phone' => 'nullable|regex:/^(\+?)([0-9] ?){9,20}$/',
            'profile_photo' => 'mimes:jpeg,png,jpg|nullable|max:1999|file',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(count($data) == 7){
            // Get filename with the extension
            $filenameWithExt = $data['profile_photo']->getClientOriginalName();
            // Get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get file extension
            $extension = $data['profile_photo']->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $data['profile_photo']->storeAs('public/profiles', $fileNameToStore);


        } else {
            $fileNameToStore = null;
        }
         
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'profile_photo' => $data['profile_photo'] = $fileNameToStore,
        ]);//projeto/storage/app/public
    }
}
