@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                @include('partials.success')
            @endif
            <div class="card">
                <div class="card-header">
                    Unauthorized
                </div>
                <div class="card-body">
                    You are not authorized to do this action!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
