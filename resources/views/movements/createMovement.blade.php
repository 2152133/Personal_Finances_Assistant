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
                    {{ __('Create New Movement') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('user.storeMovement', $account) }}" method="post" class="form-group">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="type">
                                {{ __('Movement Type') }}
                            </label>
                            <div class="col-md-6">
                                <select class="form-control" id="type" name="type">
                                    <option disabled="" selected="">
                                        -- select an option --
                                    </option>
                                    <option value="expense" {{ is_selected(old('type', $movement->type), 'expense') }}>Expense</option>
                                    <option value="revenue" {{ is_selected(old('type', $movement->type), 'revenue') }}>Revenue</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="movement_category_id">
                                {{ __('Movement Category') }}
                            </label>
                            <div class="col-md-6">
                                <select class="form-control" id="movement_category_id" name="movement_category_id">
                                    <option disabled="" selected="">
                                        -- select an option --
                                    </option>
                                    <option value="1" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '1') }}>Food</option>
                                    <option value="2" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '2') }}>Clothes</option>
                                    <option value="3" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '3') }}>Services</option>
                                    <option value="4" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '4') }}>Electricity</option>
                                    <option value="5" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '5') }}>Phone</option>
                                    <option value="6" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '6') }}>Fuel</option>
                                    <option value="7" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '7') }}>Mortgage Payment</option>
                                    <option value="8" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '8') }}>Salary</option>
                                    <option value="9" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '9') }}>Bonus</option>
                                    <option value="10" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '10') }}>Royalties</option>
                                    <option value="11" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '11') }}>Interests</option>
                                    <option value="12" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '12') }}>Gifts</option>
                                    <option value="12" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '13') }}>Dividends</option>
                                    <option value="14" {{ is_selected(old('movement_category_id', $movement->movement_category_id), '14') }}>Product Sales</option>
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
                            <label class="col-md-4 col-form-label text-md-right" for="value">
                                {{ __('Movement Value') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" id="value" name="value" type="text" value="{{ old('value') }}">
                                    @if ($errors->has('value'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('value') }}
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
