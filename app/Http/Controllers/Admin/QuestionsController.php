<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question' => 'required',
            'points' => 'required',
            'type' => 'required',
        ]);

        $test = $quiz->questions()->sum('points') + $request->points;

        if ((int) $quiz->objective < $test && $test > 100) {
            return redirect()
                ->back()
                ->with('error', 'Pour ajouter une nouvelle question, veuillez ajuster l\'objectif du quiz.');
        }

        $quiz->questions()->create([
            'text' => $request->question,
            'points' => $request->points,
            'type' => $request->type,
        ]);

        return redirect()
            ->back()
            ->with('success', 'La question a été ajouter.');
    }

    public function show(Question $question)
    {
        return view('admin.questions.show', compact('question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $request->validate([
            'question' => 'required',
            'points' => 'required',
            'type' => 'required',
        ]);

        if ((int) $quiz->objective < $quiz->questions()->sum('points')) {
            return redirect()
                ->back()
                ->with('error', 'Veuillez ajuster l\'objectif du quiz.');
        }

        $question->update([
            'text' => $request->question,
            'points' => $request->points,
            'type' => $request->type,
        ]);

        return redirect()->back()
            ->with('success', 'La question a été modifier.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()
            ->back()
            ->with('success', 'La question a été supprimer.');
    }
}
