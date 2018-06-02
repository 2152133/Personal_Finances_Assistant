@extends('layouts.app')

@section('title', '- Dashboard')
@section('content')
<div class="container">
    @if(session('success'))
            @include('partials.success')
        @endif
    <div class="row justify-content-center">
        <div>Hello, {{Auth::user()->name}}</div>
    </div>
    
    <div>
        <div class="text-center">
            
            <!-- Informaçao do dinheiro total -->
            <div class="card">
                
                <h1 class="card-header">Your total balance</h1>
                
                <h2>{{$totalBalance}}€</h2>
            
            </div>
        
            <!-- tabela com a informaçao das contas -->
            <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Account Id</th>
                    <th class="text-center">Account Type</th>
                    <th class="text-center">% from total Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userAccounts as $account)
                    <tr>
                        <td>{{$account->id}}</td>
                        <td>{{$account->name}}</td> 
                        
                        @if($totalBalance != 0)
                            <td>{{round(($account->current_balance/$totalBalance*100), 2)}}%</td>
                        @else
                            <td>Division by 0!</td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection