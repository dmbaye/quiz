@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-outline mb-3">
                            <input type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ $email ?? old('email') }}"
                                required
                                autocomplete="email"
                                autofocus>

                            <label for="email" class="form-label">
                                {{ __('Email Address') }}
                            </label>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                                autocomplete="new-password">

                            <label for="password" class="form-label">
                                {{ __('Password') }}
                            </label>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password"
                                name="password_confirmation"
                                id="password-confirm"
                                class="form-control"
                                required
                                autocomplete="new-password">

                            <label for="password-confirm" class="form-label">
                                {{ __('Confirm Password') }}
                            </label>
                        </div>

                        <div class="d-grip gap-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
