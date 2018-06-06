@extends('layouts.app')

@section('content')

@if (count($users))
<div class="container">
    <h3>
        @if ($users->count() == 1)
            {{ $users->count() }} User
        @else
            {{ $users->count() }} Users
        @endif
    </h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    User name
                </th>
                <th>
                    Email
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($me->associatedMembers as $user)
            <tr>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    <form action="{{ action('UserController@removeFromMyGroup', $user->id ) }}" class="inline" method="post">
                    @csrf
                    @method('delete')
                    <input class="btn btn-xs btn-danger custom1" type="submit" value="{{ __('remover') }} ">
                    </input>
                    </form>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="container">
    <h2>
        No associates found
    </h2>
</div>
@endif
@endsection
