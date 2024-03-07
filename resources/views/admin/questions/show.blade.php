@extends('layouts.dashboard')

@section('content')
<section class="mb-4">
    <div class="container">
        <h4 class="mb-4"><a href="{{ route('quizzes.index') }}">{{ __('Quiz') }}</a>/<a href="{{ route('quizzes.show', $question->quiz) }}">{{ $question->quiz->name }}</a>/{{ $question->text }}</h4>
        <p>{{ __('Type de question : ') . $question->type }}</p>
    </div>
</section>

<section class="mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Réponses') }}</div>

                    <div class="card-body">
                        @if ($question->answers->count())
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Answer') }}</th>
                                            <th>{{ __('Validité') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($question->answers as $index => $answer)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $answer->text }}</td>
                                                <td>
                                                    @if ($answer->valid == 1)
                                                        <span class="badge badge-success">{{ __('Vrai') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('Faux') }}</span>
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
                                                            <li>
                                                                <a href="#"
                                                                    class="dropdown-item"
                                                                    data-mdb-toggle="modal"
                                                                    data-mdb-target="#editAnswerModal-{{ $answer->id }}">
                                                                    {{ __('Modifier') }}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#"
                                                                    class="dropdown-item"
                                                                    onclick="event.preventDefault();
                                                                    document.getElementById('delete-form-{{ $answer->id }}').submit();">
                                                                    {{ __('Supprimer') }}
                                                                </a>
                                                            </li>
                                                        </ul>

                                                        <form id="delete-form-{{ $answer->id }}"
                                                            action="{{ route('answers.delete', [$question, $answer]) }}"
                                                            method="POST"
                                                            class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Edit Answer Modal -->
                                            @include('partials.modals.answers.edit')
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>{{ __('Ajouter des réponses à question.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Ajouter Résponse') }}</div>

                    <div class="card-body">
                        <form action="{{ route('answers.store', $question) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="answer" class="mb-1">
                                    {{ __('Réponse') }}
                                </label>

                                <textarea name="answer"
                                    id="answer"
                                    rows="3"
                                    cols="10"
                                    class="form-control @error('answer') is-invalid @enderror"
                                    placeholder="Réponse">{{ old('answer') }}</textarea>

                                @error('answer')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select name="validity"
                                    id="validity"
                                    class="form-select @error('validity') is-invalid @enderror">
                                    <option value="">{{ __('Validité') }}</option>
                                    <option value="1">{{ __('Vrai') }}</option>
                                    <option value="0">{{ __('Faux') }}</option>
                                </select>

                                @error('validity')
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
@endsection
