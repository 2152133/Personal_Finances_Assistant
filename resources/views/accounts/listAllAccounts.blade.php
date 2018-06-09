@extends('layouts.app')
@section('content')

@can('view-user-accounts', $user_id)
    @if (count($accounts))
    <div class="container">
        <h3>
            @if ($accounts->count() == 1)
                {{ $accounts->count() }} Account
            @else
                {{ $accounts->count() }} Accounts
            @endif
        </h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        Code
                    </th>
                    <th>
                        Account Type
                    </th>
                    <th>
                        Start Balance
                    </th>
                    <th>
                        Current Balance
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                <tr>
                    <td>
                        {{ $account->code }}
                    </td>
                    <td>
                        {{ $account->name }}
                    </td>
                    <td>
                        {{ $account->start_balance}}
                    </td>
                    <td>
                        {{ $account->current_balance }}
                    </td>
                    <td>
                        @can('edit-delete-user-accounts', $user_id)
                            <a class="btn btn-xs btn-primary" href="{{ action('AccountController@edit', $account->id) }}">Edit Account</a>
                        @endcan
                        
                        <a class="btn btn-xs btn-primary" href="{{ action('MovementController@listAllMovements', $account->id) }}">View Movements</a>
                        
                        @can('edit-delete-user-accounts', $user_id)
                            <form action="{{ action('AccountController@delete', $account) }}" method="post" class="inline">
                                @csrf
                                @method('delete')
                                <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                            </form> 
                        @endcan
                    </td>  
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="container">
        <h2>
            No accounts found
        </h2>
    </div>
    @endif
@endcan
@cannot('view-user-accounts', $user_id)
    <div class="container">
        <div class="text-right">
            <h2 class="text-center">You are not allowed to see this</h2>
        </div>
    </div>
@endcannot
@endsection
