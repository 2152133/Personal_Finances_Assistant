@extends('layouts.app')

@section('content')

@if (count($users))
<div class="container">
    <div>
    	<form action="{{ route('users') }}" class="inline" method="get" role="search">
	        <div class="input-group custom-search-form">
                <table class="table table-striped">
                    <thead>
                        <th>
                            Name
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                               <input class="form-control" name="name" type="text"/> 
                            </td>
                            <td>
                                <select name="admin" id="inputType" class="form-control">
                                    <option></option>
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </td>
                            <td>
                                <select name="blocked" id="inputType" class="form-control">
                                    <option></option>
                                    <option value="0">Unblocked</option>
                                    <option value="1">Blocked</option>
                                </select>
                            </td>
                            <td>
                                <span class="input-group-btn">
                                    <button class="btn btn-default-sm" type="submit">
                                        <i class="fa fa-search">Search</i>
                                    </button>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
	            
	            
	        </div>
        </form>
    </div>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Email
                </th>
                <th>
                    Type
                </th>
                <th>
                    Status
                </th>
                <th>
                	Change Type
                </th>
                <th>
                	Change Status
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    {{ $user->type() }}
                </td>
                <td>
                    {{ $user->status() }}
                </td>
                <td>
                    @if ($user->blocked === 0)
	                    <form action="{{ action('UserController@block', $user->id ) }}" class="inline" method="post">
	                        @csrf
						@method('patch')
	                        <input class="btn btn-xs btn-danger custom1" type="submit" value="{{ $user->buttonStatus() }} ">
	                        </input>
	                    </form>
                    @else
	                    <form action="{{ action('UserController@unblock', $user->id ) }}" class="inline" method="post">
	                        @csrf
						@method('patch')
	                        <input class="btn btn-xs btn-danger custom1" type="submit" value="{{ $user->buttonStatus() }} ">
	                        </input>
	                    </form>
                    @endif
                </td>
                <td>    
					@if ($user->admin === 0)
	                    <form action="{{ action('UserController@promote', $user->id ) }}" class="inline" method="post">
	                        @csrf
						@method('patch')
	                        <input class="btn btn-xs btn-primary custom" type="submit" value="{{ $user->buttonType() }} ">
	                        </input>
	                    </form>
                    @else
	                    <form action="{{ action('UserController@demote', $user->id ) }}" class="inline" method="post">
	                        @csrf
						@method('patch')
	                        <input class="btn btn-xs btn-primary custom" type="submit" value="{{ $user->buttonType() }} ">
	                        </input>
	                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@else
<div class="container">
    <h2>
        No users found
    </h2>
</div>
@endif
@endsection
