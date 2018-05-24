@extends('layouts.app')
@section('content')

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
                    Current Balance
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
                    {{ $account->current_balance }}
                </td>
                <td>
                    <form action="{{ action('AccountController@reopen', $account->id) }}" method="post" class="inline">
                        @csrf
                        @method('patch')
                        <input type="submit" class="btn btn-xs btn-success" value="Open Account">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<h2>
    No users found
</h2>
@endif
@endsection