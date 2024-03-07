@extends('layouts.dashboard')

@section('content')
<section>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>{{ __('Quiz Actifs') }}</span>

                <div class="d-flex">
                    <form action="" method="GET" class="me-4">
                        <input type="text"
                            name="search"
                            id="search"
                            placeholder="Rechercher quiz..."
                            value="{{ request()->search ?? '' }}"
                            class="form-control form-control-sm">
                    </form>

                    <div>
                        <a href="#"
                            class="btn btn-sm btn-success"
                            data-mdb-toggle="modal"
                            data-mdb-target="#addQuizModal">
                            {{ __('Ajouter Quiz') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if ($quizzes->count())
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('Nom Quiz') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Durée') }}</th>
                                <th>{{ __('Objectif') }}</th>
                                <th>{{ __('Publier') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quizzes as $quiz)
                                <tr>
                                    <td>
                                        <a href="{{ route('quizzes.show', $quiz) }}">
                                            {{ $quiz->name }}
                                        </a>
                                    </td>
                                    <td>{{ $quiz->start_date->diffForHumans() }}</td>
                                    <td>{{ $quiz->duration }} minutes</td>
                                    <td>{{ $quiz->objective }}</td>
                                    <td>
                                        @if ($quiz->is_published)
                                            <span class="badge badge-success">{{ __('Publier') }}</span>
                                        @else
                                            <span class="badge badge-info">{{ __('Non Publier') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($quiz->is_archived)
                                            <span class="badge badge-warning">{{ __('Archiver') }}</span>
                                        @else
                                            <span class="badge badge-info">{{ __('Actif') }}</span>
                                        @endif
                                    </td>
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
                                                @if ($quiz->questions->count() && $quiz->objective === $quiz->questions->sum('points') && ! $quiz->is_published && ! $quiz->is_archived)
                                                    <li>
                                                        <a href="#"
                                                            class="dropdown-item"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('publish-form-{{ $quiz->id }}').submit();">
                                                            {{ __('Publier') }}
                                                        </a>
                                                    </li>
                                                @endif

                                                <li>
                                                    <a href="#"
                                                        class="dropdown-item"
                                                        data-mdb-toggle="modal"
                                                        data-mdb-target="#editQuizModal-{{ $quiz->id }}">
                                                        {{ __('Modifier') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#"
                                                        class="dropdown-item"
                                                        data-mdb-toggle="modal"
                                                        data-mdb-target="#duplicateQuizModal-{{ $quiz->id }}">
                                                        {{ __('Dupliquer') }}
                                                    </a>
                                                </li>

                                                @if (! $quiz->is_archived)
                                                    <li>
                                                        <a href="#"
                                                            class="dropdown-item"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('archive-form-{{ $quiz->id }}').submit();">
                                                            {{ __('Archiver') }}
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="#"
                                                            class="dropdown-item"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('unarchive-form-{{ $quiz->id }}').submit();">
                                                            {{ __('Désarchiver') }}
                                                        </a>
                                                    </li>
                                                @endif

                                                <li>
                                                    <a href="#"
                                                        class="dropdown-item"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('delete-form-{{ $quiz->id }}').submit();">
                                                        {{ __('Supprimer') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <form id="publish-form-{{ $quiz->id }}"
                                                action="{{ route('quizzes.publish', $quiz) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="archive-form-{{ $quiz->id }}"
                                                action="{{ route('quizzes.archive', $quiz) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="unarchive-form-{{ $quiz->id }}"
                                                action="{{ route('quizzes.unarchive', $quiz) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <form id="delete-form-{{ $quiz->id }}"
                                                action="{{ route('quizzes.delete', $quiz) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Quiz Modal -->
                                @include('partials.modals.quizzes.edit')

                                <!-- Duplicate Quiz Modal -->
                                @include('partials.modals.quizzes.duplicate')
                            @endforeach
                        </tbody>
                    </table>

                    {{ $quizzes->links() }}
                @else
                    <p>{{ __('Vous n\'avez pas encore ajoute de quiz.') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="mt-4">
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Quiz Archivés') }}</div>

            <div class="card-body">
                @if ($archivedQuizzes->count())
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('Nom Quiz') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Durée') }}</th>
                                <th>{{ __('Objectif') }}</th>
                                <th>{{ __('Publier') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($archivedQuizzes as $quiz)
                                <tr>
                                    <td>
                                        <a href="{{ route('quizzes.show', $quiz) }}">
                                            {{ $quiz->name }}
                                        </a>
                                    </td>
                                    <td>{{ $quiz->start_date->diffForHumans() }}</td>
                                    <td>{{ $quiz->duration }}</td>
                                    <td>{{ $quiz->objective }}</td>
                                    <td>
                                        @if ($quiz->is_published)
                                            <span class="badge badge-success">{{ __('Publier') }}</span>
                                        @else
                                            <span class="badge badge-info">{{ __('Non Publier') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($quiz->is_archived)
                                            <span class="badge badge-warning">{{ __('Archiver') }}</span>
                                        @else
                                            <span class="badge badge-info">{{ __('Actif') }}</span>
                                        @endif
                                    </td>
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
                                                @if (! $quiz->is_archived)
                                                    <li>
                                                        <a href="#"
                                                            class="dropdown-item"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('archive-form-{{ $quiz->id }}').submit();">
                                                            {{ __('Archiver') }}
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="#"
                                                            class="dropdown-item"
                                                            onclick="event.preventDefault();
                                                            document.getElementById('unarchive-form-{{ $quiz->id }}').submit();">
                                                            {{ __('Désarchiver') }}
                                                        </a>
                                                    </li>
                                                @endif

                                                <li>
                                                    <a href="#"
                                                        class="dropdown-item"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('delete-form-{{ $quiz->id }}').submit();">
                                                        {{ __('Supprimer') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <form id="publish-form-{{ $quiz->id }}"
                                                action="{{ route('quizzes.publish', $quiz) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="archive-form-{{ $quiz->id }}"
                                                action="{{ route('quizzes.archive', $quiz) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="unarchive-form-{{ $quiz->id }}"
                                                action="{{ route('quizzes.unarchive', $quiz) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <form id="delete-form-{{ $quiz->id }}"
                                                action="{{ route('quizzes.delete', $quiz) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $archivedQuizzes->links() }}
                @else
                    <p>{{ __('Vous n\'avez pas encore ajoute de quiz.') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@include('partials.modals.quizzes.create')
