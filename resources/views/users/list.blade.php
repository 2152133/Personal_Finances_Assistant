@extends('layouts.app')

@section('content')

@if (count($users))
<div class="container">
    <div>
        {!! Form::open(['method'=>'GET','route'=>'users','class'=>'navbar-form navbar-left','role'=>'search'])  !!}
        <div class="input-group custom-search-form">
            <input class="form-control" name="name" placeholder="Search..." type="text"/>
            <input class="form-control" name="admin" placeholder="Search..." type="text"/>
            <input class="form-control" name="blocked" placeholder="Search..." type="text"/>
            <span class="input-group-btn">
                <button class="btn btn-default-sm" type="submit">
                    <i class="fa fa-search">
                        Submit
                    </i>
                </button>
            </span>
        </div>
        {!! Form::close() !!}
    </div>
    <table class="table table-striped">
        <thead>
            <h3>
                {{ $users->total() }} Total Users
            </h3>
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
<h2>
    No users found
</h2>
@endif
@endsection
