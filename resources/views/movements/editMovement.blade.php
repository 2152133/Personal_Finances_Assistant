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
                    <form action="{{ route('user.updateMovement', $movement) }}" method="post" class="form-group">
                        @method('put')
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
                            <label class="col-md-4 col-form-label text-md-right" for="date">
                                {{ __('Date') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" id="date" name="date" type="date" value="{{ old('date', $movement->date) }}">
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
                                <input autofocus="" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" id="value" name="value" type="text" value="{{ old('value', $movement->value) }}">
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
