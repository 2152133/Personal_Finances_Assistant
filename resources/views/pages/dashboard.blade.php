@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Hello, José</div>
            </div>
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4">

        </div>
    </div>
    
    <br>
    
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Your total balance</div>
                
                4366.32€
            </div>
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
            <p>multibanco - 32%</p>
            <p>carteira - 14%</p>
            <p>cartão de estudante - 52%</p>
        </div>
    </div>

    <br>
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <button type="button" class="btn btn-default">View my accounts</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-default">View my associate members</button>
        </div>
    </div>
</div>
@endsection