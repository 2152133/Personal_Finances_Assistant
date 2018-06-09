@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.storeAccount') }}" method="post" class="form-group">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="account_type_id">
                                {{ __('Account Type') }}
                            </label>
                            <div class="col-md-6">
                                <select class="form-control{{ $errors->has('account_type_id') ? ' is-invalid' : '' }}" id="account_type_id" name="account_type_id">
                                    <option disabled="" selected="">
                                        -- select an option --
                                    </option>
                                    <option value="1" {{ is_selected(old('account_type_id', $account->account_type_id), '1' ) }}>Bank account</option>
                                    <option value="2" {{ is_selected(old('account_type_id', $account->account_type_id), '2' ) }}>Pocket Money</option>
                                    <option value="3" {{ is_selected(old('account_type_id', $account->account_type_id), '3' ) }}>PayPal account</option>
                                    <option value="4" {{ is_selected(old('account_type_id', $account->account_type_id), '4' ) }}>Credit card</option>
                                    <option value="5" {{ is_selected(old('account_type_id', $account->account_type_id), '5' ) }}>Meal card</option>
                                </select>
                                @if ($errors->has('account_type_id'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('account_type_id') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="date">
                                {{ __('Date') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" id="date" name="date" type="date" value="{{ old('date', $account->date) }}">
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
                                <input autofocus="" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" id="code" name="code" type="text" value="{{ old('code') }}" required="">
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
