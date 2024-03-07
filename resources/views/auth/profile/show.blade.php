@extends('layouts.dashboard')

@section('content')
<section class="mt-4">
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Profil') }}</div>

            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-outline mb-3">
                        <input type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', auth()->user()->name) }}"
                            class="form-control @error('name') is-invalid @enderror">

                        <label for="name" class="form-label">{{ __('Prénom et nom') }}</label>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Sauvegarder') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="mt-4">
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Mot de passe') }}</div>

            <div class="card-body">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-outline mb-3">
                        <input type="password"
                            name="current_password"
                            id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror">

                        <label for="current_password" class="form-label">
                            {{ __('Mot de passe actuel') }}
                        </label>

                        @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-outline mb-3">
                        <input type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror">

                        <label for="password" class="form-label">
                            {{ __('Nouveau mot de passe') }}
                        </label>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-outline mb-3">
                        <input type="password"
                            name="password_confirmation"
                            id="password-confirm"
                            class="form-control">

                        <label for="password-confirm" class="form-label">
                            {{ __('Confirmation mot de passe') }}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Sauvegarder') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
