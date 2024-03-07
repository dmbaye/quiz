@extends('layouts.dashboard')

@section('content')
<section>
    <div class="container">
        <h1 class="mb-4">{{ $user->name }}</h1>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>{{ __('Informations Utilisateur') }}</span>

                <div class="mb-0">
                    <a href="#"
                        class="btn btn-sm btn-success"
                        data-mdb-toggle="modal"
                        data-mdb-target="#addUserModal">
                        {{ __('Modifier Utilisateur') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Prénom et nom') }}</label>

                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>

                        <input type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}">

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">{{ __('Login') }}</label>

                        <input type="text"
                            name="username"
                            id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $user->username) }}">

                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <select name="role"
                            id="role"
                            class="form-select">
                            <option value="">{{ __('Role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', $user->roles[0]->name == $role->name) ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('role')
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
        <h2>{{ __('Quizzes') }}</h2>

        <div class="card">
            <div class="card-header"></div>

            <div class="card-body">
                @if ($user->quizzes->count())
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Quiz') }}</th>
                                <th>{{ __('Categorie') }}</th>
                                <th>{{ __('Durée') }}</th>
                                <th>{{ __('Note') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->quizzes as $index => $quiz)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('quizzes.view', [auth()->user(), $quiz]) }}">
                                            {{ $quiz->name }}
                                        </a>
                                    </td>
                                    <td>{{ $quiz->category->name }}</td>
                                    <td>{{ $quiz->duration . __(' Minutes') }}</td>
                                    <td>
                                        @if ($quiz->objective === $quiz->pivot->score)
                                            <span class="badge badge-success">
                                                {{ $quiz->pivot->score }}
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                {{ $quiz->pivot->score }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($quiz->users()->find($user->id)->pivot->is_completed !== 1 || auth()->user()->questions()->count() > 0)
                                            <a href="{{ route('quizzes.view', [auth()->user(), $quiz]) }}" class="btn btn-sm btn-secondary">
                                                {{ __('Resultats') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Aucune données pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
