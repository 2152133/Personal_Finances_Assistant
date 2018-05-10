@extends('layouts.app')
@section('content')

<div><a class="btn btn-primary" href="#">Add Account</a></div>
@if (count($accounts)) 
    <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Account type ID</th>
            <th>Code</th>
            <th>Description</th>
            <th>Start Balance</th>
            <th>Current Balance</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($accounts as $account)
        <tr>
            <td>{{$account->email}}</td>
            <td>{{$account->name}}</td>
            <td>{{$account->created_at}}</td>
            <td>{{$account->typeToStr($account->type) }}</td>
            <td>
                <a class="btn btn-xs btn-primary" href="#">Edit</a>
                <form action="#" method="POST" role="form" class="inline">
                    <input type="hidden" name="user_id" value="<?= intval($user->user_id) ?>">
                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
@else
    <h2>No users found</h2>
@endif
@endsection