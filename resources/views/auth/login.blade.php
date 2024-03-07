@extends('layouts.nonav')

@section('content')
<section id="login">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-4">
                @include('partials.flash')

                <h1 class="text-center mb-4">
                    <img src="{{ asset('logo.png') }}" alt="Logo" width="150">

                    <br>

                    {{ __('Connexion') }}
                </h1>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-outline mb-3">
                        <input type="text"
                            name="username"
                            id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}"
                            required
                            autocomplete="username"
                            autofocus>

                        <label for="username" class="form-label">
                            {{ __('Login') }}
                        </label>

                        @error('username')
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
                            autocomplete="current-password">

                        <label for="password" class="form-label">
                            {{ __('Mot de passe') }}
                        </label>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid gap-0">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Connexion') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
