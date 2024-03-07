@extends('layouts.app')

@section('content')
<section class="mb-4">
    <div class="container d-flex justify-content-between">
        <h2 class="mb-4">{{ __('Quiz ') . $quiz->name }}</h2>

        <div class="d-flex">
            <h3>Temps restant : <span id="counter">{{ $quiz->duration }}</span></h3>
        </div>
    </div>
</section>

<section class="mt-4">
    <div class="container">
        <form action="{{ route('participations.store', $quiz) }}" method="POST" id="form">
            @csrf

            @foreach ($quiz->questions as $question)
                <div class="card mb-4">
                    <div class="card-header">{{ $question->text }}</div>

                    <div class="card-body">
                        @foreach ($question->answers as $answer)
                            @if ($question->type === 'single')
                                <div class="form-check mb-3">
                                    <label for="{{ $question->id }}-{{ $answer->id }}"
                                        class="form-check-label">
                                        {{ $answer->text }}
                                    </label>

                                    <input type="radio"
                                        name="{{ $question->id }}"
                                        id="{{ $question->id }}-{{ $answer->id }}"
                                        value="{{ $answer->id }}"
                                        class="form-check-input">
                                </div>
                            @endif

                            @if ($question->type === 'multiple')
                                <div class="form-check mb-3">
                                    <label for="{{ $question->id }}-{{ $answer->id }}"
                                        class="form-check-label">
                                        {{ $answer->text }}
                                    </label>

                                    <input type="checkbox"
                                        name="{{ $question->id }}[]"
                                        id="{{ $question->id }}-{{ $answer->id }}"
                                        value="{{ $answer->id }}"
                                        class="form-check-input">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">
                {{ __('Sauvegarder') }}
            </button>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function startTimer(duration, display) {
        let timer = duration, minutes, seconds;

        const x = setInterval(() => {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                timer = 0;
                clearInterval(x);


                axios.put('{{ route('quiz.completed', $quiz) }}', {
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                    data: {
                        user: '{{ auth()->user() }}',
                    }
                })
                .then((response) => (response.data.message === 'Ok') ? window.location.href = '{{ route('quizzes.list') }}' : '');
            }
        }, 1000);
    }

    window.onload = async (event) => {
        let timer = 60 * {{ $quiz->duration }};
        display = document.getElementById('counter');
        startTimer(timer, display);

        await axios.put('{{ route('participations.update', $quiz) }}', {
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            data: {
                user: '{{ auth()->user() }}',
            }
        });
    };

    window.onunload = async (event) => {
        event.preventDefault();

        const response = await axios.put('{{ route('quiz.completed', $quiz) }}', {
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            data: {
                user: '{{ auth()->user() }}',
            }
        });

        (response.data.message === 'Ok')
            ? window.location.href = '{{ route('quizzes.list') }}'
            : '';
    }
</script>
@endsection
