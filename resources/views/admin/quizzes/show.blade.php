@extends('layouts.dashboard')

@section('content')
<section class="mb-4">
    <div class="container d-flex justify-content-between">
        <div class="flex-grow-1">
            <h4 class="mb-4">
                <a href="{{ route('quizzes.index') }}">{{ __('Quiz') }}</a>/{{ $quiz->name }}
            </h4>

            <div class="row">
                <div class="col-md-6">
                    <p> <i class="fa fa-calendar me-2"></i> Commence : {{ $quiz->start_date->diffForHumans() }}</p>
                    <p><i class="fa fa-trophy me-1"></i> Objectif : {{ $quiz->objective }}</p>
                    <p><i class="fa fa-clock me-2"></i> Durée : {{ $quiz->duration }} Minutes</p>
                </div>

                <div class="col-md-6">
                    <p>Catégorie : <a href="{{ route('categories.show', $quiz->category) }}">{{ $quiz->category->name }}</a></p>

                    <a href="#"
                        class="btn btn-sm btn-primary"
                        data-mdb-toggle="modal"
                        data-mdb-target="#editQuizModal">
                        {{ __('Modifier') }}
                    </a>

                    @if (
                        $quiz->questions->count() &&
                        $quiz->questions->sum('points') >= $quiz->objective &&
                        ! $quiz->is_published
                    )
                        <a href="#"
                            class="btn btn-sm btn-primary ms-2"
                            onclick="event.preventDefault();
                            document.getElementById('publish-form-{{ $quiz->id }}').submit();">
                            {{ __('Publier') }}
                        </a>

                        <form id="publish-form-{{ $quiz->id }}"
                            action="{{ route('quizzes.publish', $quiz) }}"
                            method="POST"
                            class="d-none">
                            @csrf
                            @method('PUT')
                        </form>
                    @endif

                    @if (! $quiz->is_archived)
                        <a href="#"
                            class="btn btn-sm btn-primary ms-2"
                            onclick="event.preventDefault();
                            document.getElementById('archive-form-{{ $quiz->id }}').submit();">
                            {{ __('Archiver') }}
                        </a>

                        <form id="archive-form-{{ $quiz->id }}"
                            action="{{ route('quizzes.archive', $quiz) }}"
                            method="POST"
                            class="d-none">
                            @csrf
                            @method('PUT')
                        </form>
                    @else
                        <a href="#"
                            class="btn btn-sm btn-primary ms-2"
                            onclick="event.preventDefault();
                            document.getElementById('unarchive-form-{{ $quiz->id }}').submit();">
                            {{ __('Désarchiver') }}
                        </a>

                        <form id="unarchive-form-{{ $quiz->id }}"
                            action="{{ route('quizzes.unarchive', $quiz) }}"
                            method="POST"
                            class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <div class="card-header">{{ __('Assigner en masse') }}</div>
                <div class="card-body">
                    <form action="{{ route('assignments.store', $quiz) }}" method="POST" class="d-grid gap-2 d-flex">
                        @csrf

                        <div>
                            <select name="group"
                                id="group"
                                class="form-select @error('group') is-invalid @enderror">
                                <option value="">{{ __('Utilisateurs') }}</option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ old('group') === $role->name ? 'selected' : '' }}>
                                        {{ $role->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if ($segments->count())
                            <div>
                                <select name="segment"
                                    id="segment"
                                    class="form-select @error('segment') is-invalid @enderror">
                                    <option value="">{{ __('Plateau') }}</option>

                                    @foreach ($segments as $segment)
                                        <option value="{{ $segment->id }}"
                                            {{ old('segment') == $segment->id ? 'selected' : '' }}>
                                            {{ $segment->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="segment">
                        @endif

                        <div>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Assigner Quiz') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Questions --}}
<section class="mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Questions') }}</div>

                    <div class="card-body">
                        @if ($quiz->questions->count())
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Question') }}</th>
                                        <th>{{ __('Points') }}</th>
                                        <th>{{ __('Type Question') }}</th>
                                        <th>{{ __('Réponses') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quiz->questions as $index => $question)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <a href="{{ route('questions.show', $question) }}">
                                                    {{ $question->text }}
                                                </a>
                                            </td>
                                            <td>{{ $question->points }}</td>
                                            <td>
                                                @if ($question->type === 'single')
                                                    <span class="badge badge-primary">
                                                        {{ __('Réponse Unique') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-info">
                                                        {{ __('Réponse Multiple') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $question->answers->count() }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm btn-light dropdown-toggle"
                                                        id="dropdownMenuButton1"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                data-mdb-toggle="modal"
                                                                data-mdb-target="#editQuestionModal-{{ $question->id }}">
                                                                {{ __('Modifier') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('delete-form-{{ $question->id }}').submit();">
                                                                {{ __('Supprimer') }}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <form id="delete-form-{{ $question->id }}"
                                                        action="{{ route('questions.delete', $question) }}"
                                                        method="POST"
                                                        class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Question Modal -->
                                        @include('partials.modals.questions.edit')
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>{{ __('Ajouter des questions au quiz.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Ajouter Question') }}</div>

                    <div class="card-body">
                        <form action="{{ route('questions.store', $quiz) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="question" class="mb-1">
                                    {{ __('Question') }}
                                </label>

                                <textarea name="question"
                                    id="question"
                                    rows="3"
                                    cols="10"
                                    class="form-control @error('question') is-invalid @enderror"
                                    placeholder="Question">{{ old('question') }}</textarea>

                                @error('question')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="points" class="mb-1">
                                    {{ __('Points') }}
                                </label>

                                <input type="number"
                                    name="points"
                                    id="points"
                                    placeholder="Nombre de points"
                                    class="form-control @error('points') is-invalid @enderror"
                                    value="{{ old('points') }}">

                                @error('points')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="mb-1">
                                    {{ __('Type Question') }}
                                </label>

                                <select name="type"
                                    id="type"
                                    class="form-select @error('type') is-invalid @enderror">
                                    <option value="single">{{ __('Réponse Unique') }}</option>
                                    <option value="multiple">{{ __('Réponse Multiple') }}</option>
                                </select>

                                @error('type')
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
        </div>
    </div>
</section>
{{-- End Questions --}}

<section class="mt-4">
    <div class="container">
        <div class="row">
            {{-- Unassigned Users --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ __('Utilisateurs') }}</span>

                        <div class="d-flex">
                            <form action="" class="me-4">
                                <input type="text"
                                    name="non_assigned"
                                    id="non_assigned"
                                    placeholder="Rechercher utilisateurs..."
                                    value="{{ request('non_assigned') ?? '' }}"
                                    class="form-control form-control-sm"
                                    autocomplete="off">
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($allUsers->count())
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('Login') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allUsers as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->roles[0]->display_name }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm btn-light dropdown-toggle"
                                                        id="dropdownMenuButton2"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                        <li>
                                                            <a href="{{ route('assignments.single', [$quiz, $user]) }}"
                                                                class="dropdown-item">
                                                                {{ __('Assigner') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $allUsers->links() }}
                        @else
                            <p>Tous les utilisateurs ont été assigner.</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- End Unassigned Users --}}

            {{-- Assigned Users --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>{{ __('Participants') }}</span>

                        <div class="d-flex">
                            <form action="" class="me-4">
                                <input type="text"
                                    name="assigned"
                                    id="assigned"
                                    placeholder="Rechercher participants..."
                                    value="{{ request('assigned') ?? '' }}"
                                    class="form-control form-control-sm"
                                    autocomplete="off">
                            </form>

                            <div>
                                <a href="{{ route('quizzes.export', $quiz) }}"
                                    class="btn btn-success"
                                    title="Exporter">
                                    <i class="fa fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($users->count())
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('Login') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Note') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->roles[0]->display_name }}</td>
                                            <td>
                                                @if ($user->pivot->score != '')
                                                    @if ($user->pivot->score >= $quiz->objective)
                                                        <span class="badge badge-success">
                                                            {{ $user->pivot->score }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            {{ $user->pivot->score }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span></span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm btn-light dropdown-toggle"
                                                        id="dropdownMenuButton2"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                        @if ($user->pivot->is_completed)
                                                            <li>
                                                                <a href="{{ route('quizzes.view', [$user, $quiz]) }}"
                                                                    class="dropdown-item">
                                                                    {{ __('Résultat') }}
                                                                </a>
                                                            </li>
                                                        @endif

                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('reassignment-form-{{ $user->id }}').submit();">
                                                                {{ __('Résassigner') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('unassignment-form-{{ $user->id }}').submit();">
                                                                {{ __('Désassigner') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <form id="reassignment-form-{{ $user->id }}"
                                                    action="{{ route('assignments.update', [$quiz, $user]) }}"
                                                    method="POST"
                                                    class="d-none">
                                                    @csrf
                                                    @method('PUT')
                                                </form>

                                                <form id="unassignment-form-{{ $user->id }}"
                                                    action="{{ route('assignments.delete', [$quiz, $user]) }}"
                                                    method="POST"
                                                    class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $users->links() }}
                        @else
                            <p>Ce quiz n'a pas de participants pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- End Assigned Users --}}
        </div>
    </div>
</section>
@endsection

<form action="{{ route('quizzes.update', $quiz) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal fade"
        id="editQuizModal"
        tabindex="-1"
        aria-labelledby="editQuizModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQuizModalLabel">
                        {{ __('Modifier Quiz') }}
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-mdb-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <select name="category"
                            id="category"
                            class="form-select">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category', $category->id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name">
                            {{ __('Nom Quiz') }}
                        </label>

                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $quiz->name) }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date">
                            {{ __('Date Quiz') }}
                        </label>

                        <input type="date"
                            name="date"
                            id="date"
                            class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date', $quiz->start_date->format('Y-m-d')) }}">

                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="objective">
                            {{ __('Objectif Quiz') }}
                        </label>

                        <input type="number"
                            name="objective"
                            id="objective"
                            class="form-control @error('objective') is-invalid @enderror"
                            value="{{ old('objective', $quiz->objective) }}">

                        @error('objective')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="duration">
                            {{ __('Durée Quiz') }}
                        </label>

                        <input type="number"
                            name="duration"
                            id="duration"
                            class="form-control @error('duration') is-invalid @enderror"
                            value="{{ old('duration', $quiz->duration) }}">

                        @error('duration')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-secondary"
                        data-mdb-dismiss="modal">
                        {{ __('Annuler') }}
                    </button>

                    <button type="submit"
                        class="btn btn-primary">
                        {{ __('Sauvegarder') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

