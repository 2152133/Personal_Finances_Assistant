@extends('layouts.app')
@section('content')

@can('view-account-movements', $account_id)
    <div class="container">
        <div class="text-right">
            <a class="btn btn-primary" href="#">Add movement</a>
        </div>
        @if (count($movements)) 
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Movement category ID</th>
                    <th>Date</th>
                    <th>Value</th>
                    <th>Start Balance</th>
                    <th>End Balance</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($movements as $movement)
                <tr>
                    <td>{{$movement->id}}</td>
                    <td>{{$movement->movement_category_id}}</td>
                    <td>{{$movement->date}}</td>
                    <td>{{$movement->value}}</td>
                    <td>{{$movement->start_balance}}</td>
                    <td>{{$movement->end_balance}}</td>
                    <td>{{$movement->description}}</td>
                    <td>{{$movement->type}}</td>
                    <td>
                        <a class="btn btn-xs btn-primary" href="#">Edit</a>
                        <form action="#" method="POST" role="form" class="inline">
                            <input type="hidden" name="movement_id" value="<?= intval($movement->id) ?>">
                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
        @else
            <h2 class="text-center">No movements found</h2>
        @endif
    </div>
@endcan
@cannot('view-account-movements', $account_id)
    <div class="container">
        <div class="text-right">
            <h2 class="text-center">You are not allowed to see this</h2>
        </div>
    </div>
@endcannot
@endsection