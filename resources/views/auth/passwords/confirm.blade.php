@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-outline mb-3">
                            <input type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                                autocomplete="current-password">

                            <label for="password" class="form-label">
                                {{ __('Password') }}
                            </label>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn btn-link">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        @endif

                        <div class="d-grid gap-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirmer mot de passe') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
