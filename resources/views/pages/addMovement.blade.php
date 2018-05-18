@extends('layouts.app')
@section('content')

@can('view-account-movements', $account_id)
    <div class="container">
        <div class="card">
                <div class="card-header text-center">
                    {{ __('Add movement') }}
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="category">
                                {{ __('Category') }}
                            </label>
                            <div class="col-md-6">
                                <select autofocus="" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" id="category" name="category" required="" type="text" value="{{ old('category') }}">
                                    @foreach($movement_categories as $movement_category)
                                        <option value="{{ $movement_category->id }}">{{ $movement_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="category">
                                {{ __('Date') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" id="date" name="date" required="" type="date" value="{{ old('date') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="category">
                                {{ __('Value') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" id="value" name="value" required="" type="text" value="{{ old('value') }}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="category">
                                {{ __('Description') }}
                            </label>
                            <div class="col-md-6">
                                <textarea rows="3" autofocus="" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description" required="" type="text" value="{{ old('description') }}"></textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 text-right">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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