@extends('layouts.app')

@section('title', '- Statistics')
@section('content')
<div class="container">
    
    <!-- Formulario para inserir as datas -->
    <form>
        <div class="row">
            
            <!-- Inserir a data inicial -->
            <div class="col-md-5">
                <label for="fromDate">From: </label>
                <input autofocus="" class="form-control{{ $errors->has('fromDate') ? ' is-invalid' : '' }}" id="fromDate" name="fromDate" type="date" value="{{ old('fromDate') }}">
            </div>
            
            <!-- Inserir a data final -->
            <div class="col-md-5">
                <label for="toDate">To: </label>
                <input autofocus="" class="form-control{{ $errors->has('toDate') ? ' is-invalid' : '' }}" id="toDate" name="toDate" type="date" value="{{ old('toDate') }}">
            </div>

            <!-- Botao para submeter -->
            <div class="col-md-2">
                <button class="btn btn-primary" type="submit">
                    {{ __('Submit') }}
                </button>                
            </div>

        </div>
    </form>

    <br>

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <h1 class="card-header">Statistics</h1>

                <p>Total de Receitas: </p>
                <p>Total de Despesas: </p>
            </div>
        </div>
    </div>
    
    
    

</div>
@endsection