@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Hello, {{Auth::user()->name}}</div>
            </div>
        </div>
        <div class="col-md-6 text-center">

        </div>

    </div>
    
    <br>
    
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card">
                
                <div class="card-header">Your total balance</div>
                
                {{$totalBalance}}€
            
            </div>
        </div>

        <div class="col-md-6 text-center">
            <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Account Type</th>
                    <th class="text-center">% from total Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userAccounts as $account)
                    <tr>
                        <td>{{$account->account_type_id}}</td> 
                        
                        <td>{{strval(round($account->current_balance/$totalBalance*100))}}%</td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>

    <br>
    
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <button type="button" class="btn btn-default">View my accounts</button>
        </div>
        <div class="col-md-6 text-center">
            <button type="button" class="btn btn-default">View my associate members</button>
        </div>
    </div>
</div>
@endsection