@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Register') }}
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="name">
                                {{ __('Name') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" required="" type="text" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('name') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="email">
                                {{ __('E-Mail Address') }}
                            </label>
                            <div class="col-md-6">
                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" required="" type="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('email') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="password">
                                {{ __('Password') }}
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
                                {{ __('Confirm Password') }}
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" id="password-confirm" name="password_confirmation" required="" type="password">
                                </input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="phone">
                                {{ __('Phone Number') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" type="text" value="{{ old('phone') }}">
                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('phone') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        {{-- begin --}}
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="profile_photo">
                                {{ __('Profile Picture') }}
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="{{ $errors->has('profile_photo') ? ' is-invalid' : '' }}" id="profile_photo" name="profile_photo" type="file" value="{{ old('profile_photo') }}">
                                    @if ($errors->has('profile_photo'))
                                    <span class="invalid-feedback">
                                        <strong>
                                            {{ $errors->first('profile_photo') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        {{-- end --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Register') }}
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
