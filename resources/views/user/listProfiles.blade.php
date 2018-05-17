@extends('layouts.app')

@section('content')
<div>
    @can('create', App\User::class)
    <a class="btn btn-primary" href="{{route('users.create')}}">
        Add user
    </a>
    @endcan
</div>
@if (count($users))
<div class="container">
<table class="table table-striped">
    <thead>
        <h3>{{ $users->total() }} Total Users</h3>
        <tr>
            <th>
                Profile Foto
            </th>
            <th>
                User Name
            </th>
        </tr>
    </thead>
    <tbody class="">
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
