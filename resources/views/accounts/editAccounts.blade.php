@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Edit Account') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('user.updateAccount', $account->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="account_type_id">
                                {{ __('Account Type') }}
                            </label>
                            <div class="col-md-6">
                                <select class="form-control" id="inputType" name="account_type_id"  required="">
                                    <option disabled="" selected="">
                                        -- select an option --
                                    </option>
                                    <option value="1" {{ old('account_type_id', strval($account->account_type_id)) === '1' ? "selected" : "" }}>Bank account</option>
                                    <option value="2" {{ old('account_type_id', strval($account->account_type_id)) === '2' ? "selected" : "" }}>Pocket Money</option>
                                    <option value="3" {{ old('account_type_id', strval($account->account_type_id)) === '3' ? "selected" : "" }}>PayPal account</option>
                                    <option value="4" {{ old('account_type_id', strval($account->account_type_id)) === '4' ? "selected" : "" }}>Credit card</option>
                                    <option value="5" {{ old('account_type_id', strval($account->account_type_id)) === '5' ? "selected" : "" }}>Meal card</option>
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
                            <label class="col-md-4 col-form-label text-md-right" for="code">
                                {{ __('Code') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" id="code" name="code" type="text" value="{{ old('code', $account->code) }}">
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
                            <label class="col-md-4 col-form-label text-md-right" for="date">
                                {{ __('Date') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" id="date" name="date" type="text" value="{{ old('date', $account->date) }}">
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
                            <label class="col-md-4 col-form-label text-md-right" for="description">
                                {{ __('Description') }}
                            </label>
                            <div class="col-md-6">
                                <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description"  type="text" value="{{ old('description', $account->description) }}">
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
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="start_balance">
                                {{ __('Start balance') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('start_balance') ? ' is-invalid' : '' }}" id="start_balance" name="start_balance" type="text" value="{{ old('start_balance', $account->start_balance) }}">
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
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Update') }}
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
