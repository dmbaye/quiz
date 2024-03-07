@extends('layouts.app')

@section('content')
<section class="mt-4">
    <div class="container">
        <div class="mb-4">
            <h2 class="mb-4">{{ $quiz->name }}</h2>

            <h3 class="mb-3">{{ __('Votre Note :') }} {{ $quiz->users()->where('user_id', $user->id)->first()->pivot->score }}/{{ $quiz->objective }}</h3>

            @if ($quiz->users()->where('user_id', $user->id)->first()->pivot->score >= $quiz->objective)
                <div class="alert alert-success">{{ __('Félicitaion vous avez atteint l\'objectif.') }}</div>
            @else
                <div class="alert alert-danger">{{ __('Désolé vous n\'avez pas atteint l\'objectif.') }}</div>
            @endif
        </div>

        <div class="card">
            <div class="card-header">{{ __('Details') }}</div>

            <div class="card-body">
                <ul class="list-group">
                    @foreach ($quiz->questions as $index => $question)
                        @if ($question->type == 'single')
                            @php
                                $validAnswer = $question->answers()->where('valid', 1)->first();
                                $userAnswer = $user->questions()
                                    ->where('question_id', $question->id)
                                    ->first();

                                $a = $question->answers()->where('id', $userAnswer->pivot->answer_id)->first();
                            @endphp

                            @if ($userAnswer && $userAnswer->pivot->rater == 0)
                                <li class="list-group-item" class="mb-2">
                                    <p class="mb-2"><span class="text-success">{{ $question->text }}</span> - {{ $question->points }} Points</p>
                                    <p class="mb-0">Bonne Reponse : <span class="badge badge-success">{{ $validAnswer->text }}</span></p>
                                    <p class="mb-0">Votre Reponse : <span class="badge badge-success">{{ $a->text }}</span></p>
                                </li>
                            @else
                                <li class="list-group-item" class="mb-2">
                                    <p class="mb-2"><span class="text-danger">{{ $question->text }}</span> - 0 Point</p>
                                    <p class="mb-0">Bonne Reponse : <span class="badge badge-success">{{ $validAnswer->text }}</span></p>
                                    <p class="mb-0">Votre Reponse : <span class="badge badge-danger">{{ $a->text }}</span></p>
                                </li>
                            @endif
                        @endif

                        @if ($question->type == 'multiple')
                            @php
                                $validAnswers = $question->answers()->where('valid', 1)->get();
                                $validIds = $question->answers()->where('valid', 1)->pluck('id')->all();

                                $userIds = $user->questions()
                                    ->where('question_user.quiz_id', $quiz->id)
                                    ->where('question_user.question_id', $question->id)
                                    ->pluck('answer_id')->all();

                                $userAnswers = $question->answers()->whereIn('id', $userIds)->get();
                            @endphp

                            @if (! array_diff($validIds, $userIds) == true)
                                <li class="list-group-item" class="mb-2">
                                    <p class="mb-2"><span class="text-success">{{ $question->text }}</span> - {{ $question->points }} Points</p>

                                    <p class="mb-0">Bonnes Reponses: @foreach ($validAnswers as $answer) <span class="badge badge-success">{{ $answer->text }}</span> @endforeach</p>
                                    <p class="mb-0">Vos Reponses: @foreach ($userAnswers as $answer) <span class="badge badge-success">{{ $answer->text }}</span> @endforeach</p>
                                </li>
                            @else
                                <li class="list-group-item" class="mb-2">
                                    <p class="mb-2"><span class="text-danger">{{ $question->text }}</span> - 0 Point</p>

                                    <p class="mb-0">Bonnes Reponses: @foreach ($validAnswers as $answer) <span class="badge badge-success">{{ $answer->text }}</span> @endforeach</p>
                                    <p class="mb-0">Vos Reponses: @foreach ($userAnswers as $answer) <span class="badge badge-danger">{{ $answer->text }}</span> @endforeach</p>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
