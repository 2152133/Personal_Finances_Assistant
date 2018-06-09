@extends('layouts.app')

@section('title', '- Dashboard')
@section('content')
@can('view-dashboard', $user)
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
                    
                    <h2>{{number_format($totalBalance,2)}} €</h2>
                
                </div>
            
                <!-- tabela com a informaçao das contas -->
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Account Id</th>
                        <th class="text-center">Account Type</th>
                        <th class="text-center">Account Balance</th>
                        <th class="text-center">% from total Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userAccounts as $account)
                        <tr>
                            <td>{{$account->id}}</td>
                            <td>{{$account->name}}</td> 
                            <td>{{number_format($account->current_balance,2)}} €</td>
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
@endcan
@cannot('view-dashboard', $user)
    <div class="container">
        <div class="text-right">
            <h2 class="text-center">You are not allowed to see this</h2>
        </div>
    </div>
@endcannot
@endsection