@extends('layouts.app')
@section('content')

@can('view-account-movements', $account)
<div class="container">
    @can('view-account-movements', $account)
        @can('edit-account', $account)
    <div class="text-right">
        <a class="btn btn-primary" href="{{ action('MovementController@create', $account) }}">
            Add movement
        </a>
    </div>
    <br>
        @endcan
            
        @endcan
        
        @if (count($movements))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Category ID
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
                        {{$movement->movement_category_id}}
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
                    {{--
                    <td>
                        {{$movement->document_id}}
                    </td>
                    --}}
                    <td>
                        @if ($movement->document_id != null)
                        <a class="btn btn-xs btn-primary" href="{{ action('MovementController@viewFile', $movement->document_id) }}">
                            View
                        </a>
                        <a class="btn btn-xs btn-primary" href="{{ action('MovementController@downloadFile', $movement->document_id) }}">
                            Download
                        </a>
                        @endif
                        {{-- {{ dd(action('MovementController@viewFile', $movement->document_id)) }} --}}

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
