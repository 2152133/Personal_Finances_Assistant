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
                    {{ __('Change Password') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('user.updatePassword') }}" enctype="form-control" method="POST">
                        @csrf
                        @method('patch')
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="old_password">
                                {{ __('Current Password') }}
                            </label>
                            <div class="col-md-6">
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="old_password" name="old_password" required="" type="password">
                                    @if ($errors->has('old_password'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('old_password') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="password">
                                {{ __('New Password') }}
                            </label>
                            <div class="col-md-6">
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" required="" type="password">
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('password') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="password-confirm">
                                {{ __('Confirm New Password') }}
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" id="password-confirm" name="password_confirmation" required="" type="password">
                                </input>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Reset Password') }}
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
