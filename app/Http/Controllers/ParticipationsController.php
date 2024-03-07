<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class ParticipationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Quiz $quiz)
    {
        $user = auth()->user();

        if (
            $quiz->users()->where('user_id', $user->id)->first()->pivot->is_completed === 1 ||
            $quiz->users()->where('user_id', $user->id)->first()->pivot->is_attempted === 1
        ) {
            return redirect()->route('quizzes.list');
        }

        return view('participate.show', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $score = 0;
        $user = auth()->user();

        if (count($request->except('_token')) === 0) {
            $user->quizzes()->updateExistingPivot($quiz->id, [
                'score' => $score,
                'is_completed' => true,
            ]);

            return redirect()->route('quizzes.index');
        }

        foreach ($request->except('_token') as $question => $answer) {
            $q = $quiz->questions()->where('id', $question)->first();
            $status = 1;

            if ($q->type === 'multiple') {
                $validAnsers = $quiz->questions()
                    ->where('id', $question)
                    ->first()
                    ->answers()
                    ->where('valid', 1)
                    ->pluck('id')
                    ->all();

                $as = $q->answers()->where('id', $answer)->get();

                $intAnswers = array_map(
                    function ($value) { return (int) $value; },
                    $answer
                );

                if (! array_diff($validAnsers, $intAnswers) == true) {
                    $score += $q->points;
                    $status = 0;
                }

                foreach ($answer as $a) {
                    $user->questions()->attach($question, [
                        'quiz_id' => $quiz->id,
                        'answer_id' => $a,
                        'rater' => $status,
                    ]);
                }
            } else if ($q->type === 'single') {
                $a = $q->answers()->where('id', $answer)->first();
                $status = 1;

                if ($a->id === (int) $answer && $a->valid === 1) {
                    $score += $q->points;
                    $status = 0;
                }

                $user->questions()->attach($question, [
                    'quiz_id' => $quiz->id,
                    'answer_id' => $answer,
                    'rater' => $status,
                ]);
            }
        }

        $user->quizzes()->updateExistingPivot($quiz->id, [
            'score' => $score,
            'is_completed' => true,
        ]);

        return redirect()->route('quizzes.view', [$user, $quiz]);
    }

    public function update(Request $request, Quiz $quiz)
    {
        if ($request->wantsJson()) {
            auth()->user()->quizzes()->updateExistingPivot($quiz->id, [
                'is_attempted' => true,
            ]);

            return response()->json(['message' => 'Ok']);
        }
    }
}
