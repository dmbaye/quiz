@extends('layouts.dashboard')

@section('content')
<section class="mb-4">
    <div class="container">
        <div class="card">
            <div class="card-header">{{ $category->name }} - {{ __('Quiz') }}</div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Quiz') }}</th>
                                <th>{{ __('Questions') }}</th>
                                <th>{{ __('Participants') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category->quizzes as $index => $quiz)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('quizzes.show', $quiz) }}">
                                            {{ $quiz->name }}
                                        </a>
                                    </td>
                                    <td>{{ $quiz->questions->count() }}</td>
                                    <td>{{ $quiz->users->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
