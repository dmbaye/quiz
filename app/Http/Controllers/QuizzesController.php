<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class QuizzesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $uncompletedQuizzes = auth()->user()->quizzes()->latest()->active()->published()->uncompleted()->get();
        $completedQuizzes = auth()->user()->quizzes()->latest()->active()->published()->completed()->get();

        return view('quizzes.index', compact('uncompletedQuizzes', 'completedQuizzes'));
    }

    public function show(User $user, Quiz $quiz)
    {
        $userQuestions = $user->questions('quiz_id', $quiz->id)->get();

        if (
            $quiz->users()->where('user_id', $user->id)->first()->pivot->is_completed === 0 ||
            ($quiz->users()->where('user_id', $user->id)->first()->pivot->is_completed === 1 && $user->questions()->count() === 0)
        ) {
            return redirect()->back();
        }

        return view('quizzes.show', compact('quiz', 'user', 'userQuestions'));
    }
}
