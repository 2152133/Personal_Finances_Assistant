@extends('layouts.app')
@section('content')

@can('view-account-movements', $account)
<div class="container">
    @can('edit-account', $account)
    <div class="text-right">
        <a class="btn btn-primary" href="{{ action('MovementController@create', $account) }}">
            Add movement
        </a>
    </div>
    <br>        
    @endcan
        @if (count($movements))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Value
                    </th>
                    <th>
                        Start Balance
                    </th>
                    <th>
                        End Balance
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        File
                    </th>
                    @can('edit-account', $account)
                    <th>
                        Actions
                    </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($movements as $movement)
                <tr>
                    <td>
                        {{$movement->id}}
                    </td>
                    <td>
                        {{$movement->name}}
                    </td>
                    <td>
                        {{$movement->date}}
                    </td>
                    <td>
                        {{$movement->value}}
                    </td>
                    <td>
                        {{$movement->start_balance}}
                    </td>
                    <td>
                        {{$movement->end_balance}}
                    </td>
                    <td>
                        {{$movement->description}}
                    </td>
                    <td>
                        {{$movement->type}}
                    </td>

                        <td>
                            @if(isset($movement->document_id))
                                <a class="btn btn-primary" href="{{ action('MovementController@download', $movement->document_id) }}">Download</a>
                                <a class="btn btn-primary" href="{{ action('MovementController@view', $movement->document_id) }}">View</a>
                                @can('edit-account', $account)
                                <form action="{{ action('MovementController@deleteDocument', $movement->document_id) }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>
                                @endcan
                            @else
                                @can('edit-account', $account)
                                    <a class="btn btn-success" href="{{ action('MovementController@createDocument', $movement->id) }}">Add Document</a>
                                @endcan
                            @endif
                            
                        </td>
                    @can('edit-account', $account)
                    <td>
                        <a class="btn btn-xs btn-primary" href="{{ action('MovementController@edit', $movement->id) }}">
                            Edit Movement
                        </a>
                        <form action="{{ action('MovementController@delete', $movement) }}" class="inline" method="post">
                            @csrf
                            @method('delete')
                            <input class="btn btn-xs btn-danger" type="submit" value="Delete">
                            </input>
                        </form>
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <h2 class="text-center">
            No movements found
        </h2>
        @endif
    </br>
</div>
@endcan
@cannot('view-account-movements', $account)
<div class="container">
    <div class="text-right">
        <h2 class="text-center">
            You are not allowed to see this
        </h2>
    </div>
</div>
@endcannot
@endsection
