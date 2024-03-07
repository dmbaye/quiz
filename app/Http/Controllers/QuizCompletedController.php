<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizCompletedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request, Quiz $quiz)
    {
        if ($request->wantsJson()) {
            auth()->user()->quizzes()->updateExistingPivot($quiz->id, [
                'is_completed' => true,
            ]);

            return response()->json(['message' => 'Ok']);
        }
    }
}
