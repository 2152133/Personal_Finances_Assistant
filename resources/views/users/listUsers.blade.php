@extends('layouts.app')

@section('content')

@if (count($users))
<div class="container">
    @if(session('error'))
        @include('partials.error')
    @endif
    <h3>
        @if ($users->total() == 1)
            {{ $users->total() }} User
        @else
            {{ $users->total() }} Users
        @endif
    </h3>
    <div>
        <form action="{{ route('users') }}" class="navbar-form navbar-left" method="get" role="search">
            <div class="input-group custom-search-form">
                <input class="form-control" id="name" name="name" placeholder="Search..." type="text"/>
                <select class="form-control" id="admin" name="admin">
                    <option disabled="" selected="">
                        -- user type --
                    </option>
                    <option value="0">
                        Normal
                    </option>
                    <option value="1">
                        Admin
                    </option>
                </select>
                <select class="form-control" id="blocked" name="blocked">
                    <option disabled="" selected="">
                        -- user status --
                    </option>
                    <option value="0">
                        Unblocked
                    </option>
                    <option value="1">
                        Blocked
                    </option>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-default-sm" type="submit">
                        <i class="fa fa-search">
                            Search
                        </i>
                    </button>
                </span>
            </div>
        </form>
    </div>
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
                    @if ($user->blocked == 0)
                    <form action="{{ action('UserController@block', $user ) }}" class="inline" method="post" title="Block">
                        @csrf
                        @method('patch')
                        <input class="btn btn-xs btn-danger custom1" type="submit" value="{{ $user->buttonStatus() }} ">
                        </input>
                    </form>
                    @else
                    <form action="{{ action('UserController@unblock', $user ) }}" class="inline" method="post" title="Unblock">
                        @csrf
                        @method('patch')
                        <input class="btn btn-xs btn-danger custom1" type="submit" value="{{ $user->buttonStatus() }} ">
                        </input>
                    </form>
                    @endif
                </td>
                <td>
                    @if ($user->admin == 0)
                    <form action="{{ action('UserController@promote', $user ) }}" class="inline" method="post">
                        @csrf
                        @method('patch')
                        <input class="btn btn-xs btn-primary custom" type="submit" value="{{ $user->buttonType() }} ">
                        </input>
                    </form>
                    @else
                    <form action="{{ action('UserController@demote', $user ) }}" class="inline" method="post">
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
