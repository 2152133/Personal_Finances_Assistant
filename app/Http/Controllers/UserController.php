<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    public function count(){

		$users = User::All();

		return view('pages.index', compact('users'));
		//dd($this);

    }

    public function index(){

		$users = User::All();
		$pagetitle = "List of Users";
		

		
		return view('users.list', compact('users', 'pagetitle'));
		//dd($this);

    }
}
