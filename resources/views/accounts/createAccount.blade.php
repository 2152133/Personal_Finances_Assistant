@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ($errors->any())
                    @include('partials.errors')
                @endif
                <div class="card-header">
                    {{ __('Create New Account') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('user.storeAccount') }}" method="post" class="form-group">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="inputType">
                                {{ __('Account Type') }}
                            </label>
                            <div class="col-md-6">
                                <select class="form-control" id="inputType" name="account_type_id">
                                    <option disabled="" selected="">
                                        -- select an option --
                                    </option>
                                    <option {{is_selected(old('account_type_id', $account->account_type_id), '1' )}} value="1">Bank account</option>
                                        <option {{is_selected(old('account_type_id', $account->account_type_id), '2' )}} value="2">Pocket Money</option>
                                        <option {{is_selected(old('account_type_id', $account->account_type_id), '3' )}} value="3">PayPal account</option>
                                        <option {{is_selected(old('account_type_id', $account->account_type_id), '4' )}} value="4">Credit card</option>
                                        <option {{is_selected(old('account_type_id', $account->account_type_id), '5' )}} value="5">  Meal card</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="date">
                                {{ __('Date') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" id="date" name="date" type="date" value="{{ old('date') }}">
                                    @if ($errors->has('date'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('date') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="code">
                                {{ __('Account Code') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" id="code" name="code" type="text" value="{{ old('code') }}">
                                    @if ($errors->has('code'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('code') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="start_balance">
                                {{ __('Start Balance') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('start_balance') ? ' is-invalid' : '' }}" id="start_balance" name="start_balance" type="text" value="{{ old('start_balance') }}">
                                    @if ($errors->has('start_balance'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('start_balance') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="description">
                                {{ __('Description') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description" type="text" value="{{ old('description') }}">
                                    @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('description') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
