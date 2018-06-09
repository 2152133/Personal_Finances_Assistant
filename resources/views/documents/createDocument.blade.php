@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Add Document') }}
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ action('MovementController@storeDocument', $movement) }}" method="post">
                        @csrf
                        {{-- begin --}}
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="original_name">
                                {{ __('Document') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="{{ $errors->has('original_name') ? ' is-invalid' : '' }}" id="original_name" name="original_name" type="file" value="{{ old('original_name') }}">
                                    @if ($errors->has('original_name'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('original_name') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        {{-- end --}}
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
                                    {{ __('Add Document') }}
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
