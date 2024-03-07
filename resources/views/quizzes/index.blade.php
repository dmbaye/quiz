@extends('layouts.app')

@section('content')
<section class="mt-4">
    <div class="container">
        <h1 class="mb-4">{{ __('Quiz') }}</h1>

        <div class="card">
            <div class="card-header">{{ __('Quiz Actifs') }}</div>

            <div class="card-body">
                @if ($uncompletedQuizzes->count())
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Quiz') }}</th>
                                <th>{{ __('Categorie') }}</th>
                                <th>{{ __('Objectif') }}</th>
                                <th>{{ __('Durée') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uncompletedQuizzes as $index => $quiz)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $quiz->name }}</td>
                                    <td>{{ $quiz->category->name }}</td>
                                    <td>{{ $quiz->objective }}</td>
                                    <td>{{ $quiz->duration . __(' Minutes') }}</td>
                                    <td>
                                        @if (! $quiz->pivot->is_attempted || ! $quiz->pivot->is_completed)
                                            <a href="{{ route('participations.create', $quiz) }}"
                                                class="btn btn-sm btn-secondary">
                                                {{ __('Participer') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Vous n'avez pas de quiz assigner pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="mt-4">
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Anciens Quiz') }}</div>

            <div class="card-body">
                @if ($completedQuizzes->count())
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
                            @foreach ($completedQuizzes as $index => $quiz)
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
                                        @if ($quiz->pivot->score >= $quiz->objective)
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
                                        @if (
                                            $quiz->users()->where('user_id', auth()->user()->id)->first()->pivot->is_completed !== 1 ||
                                            auth()->user()->questions()->count() > 0
                                        )
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
                    <p>Vous n'avez pas participer à des quiz pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
