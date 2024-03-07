<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DuplicateQuizzesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([]);

        $newQuiz = Quiz::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'start_date' => $request->date,
            'objective' => $request->objective,
            'duration' => $request->duration,
        ]);

        foreach ($quiz->questions as $question) {
            $q = $newQuiz->questions()->create([
                'text' => $question->text,
                'points' => $question->points,
                'type' => $question->type,
            ]);

            foreach ($question->answers as $answer) {
                $q->answers()->create([
                    'text' => $answer->text,
                    'valid' => $answer->valid,
                ]);
            }
        }

        return redirect()->route('quizzes.show', $newQuiz);
    }
}
