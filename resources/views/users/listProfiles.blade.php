@extends('layouts.app')

@section('content')

@if (count($users))
<div class="container">
    <h3>
        @if ($users->total() == 1)
            {{ $users->total() }} User
        @else
            {{ $users->total() }} Users
        @endif
    </h3>
    <div>
        {!! Form::open(['method'=>'GET','route'=>'user.listProfiles','class'=>'navbar-form navbar-left','role'=>'search'])  !!}
        <div class="input-group custom-search-form">
            <input class="form-control" name="name" placeholder="Search..." type="text"/>
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
            <tr>
                <th>
                    Profile Foto
                </th>
                <th>
                    User Name
                </th>
                <th>
                    Association
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>
                    @if ($user->profile_photo != null)
                    <img src="/storage/profiles/{{ $user->profile_photo }}" style="width:50px; height:50px; float:left; border-radius:50%; margin-right:25px;"/>
                    @else
                    <img src="/storage/profiles/default" style="width:50px; height:50px; float:left; border-radius:50%; margin-right:25px;"/>
                    @endif
                </td>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    @if (App\User::find(Auth::user()->id)->associatedMembers->count() != 0 && $user->id == App\User::find(Auth::user()->id)->associatedMembers->toArray()[0]['pivot']['associated_user_id'])
                    {{ __('Belongs to my group') }}
                @elseif (App\User::find(Auth::user()->id)->associatedTo->count() != 0 && $user->id == App\User::find(Auth::user()->id)->associatedTo->toArray()[0]['pivot']['main_user_id'])
                    {{ __('Belongs to his group') }}
                @elseif ($user->id == Auth::user()->id)
                    {{ __('My group') }}
                @else
                    {{ __('There is no association') }}
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
        No profiles found
    </h2>
</div>
@endif
@endsection
