@extends('layouts.app')
@section('content')

@can('view-account-movements', $account)
    <div class="container">
        <div class="text-right">
            <a class="btn btn-primary" href="{{ action('MovementController@create', $account) }}">Add movement</a>
        </div>
        @if (count($movements)) 
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category ID</th>
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
                        <a class="btn btn-xs btn-primary" href="{{ action('MovementController@edit', $movement->id) }}">Edit Movement</a>
                        <form action="{{ action('MovementController@delete', $movement) }}" method="post" class="inline">
                            @csrf
                            @method('delete')
                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
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
@cannot('view-account-movements', $account)
    <div class="container">
        <div class="text-right">
            <h2 class="text-center">You are not allowed to see this</h2>
        </div>
    </div>
@endcannot
@endsection