<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function store(Request $request, Question $question)
    {
        $request->validate([
            'answer' => 'required',
            'validity' => 'nullable',
        ]);

        if (
            $question->answers()->where('valid', 1)->first() &&
            $question->type === 'single' &&
            (int) $request->validity === 1
        ) {
            return redirect()
                ->back()
                ->with('error', 'Une question a réponse unique ne peut pas avoir plusieurs réponse valide');
        }

        $question->answers()->create([
            'text' => $request->answer,
            'valid' => $request->validity == 1 ? true : false,
        ]);

        return redirect()
            ->back()
            ->with('success', 'La réponse a été ajouter.');
    }

    public function update(Request $request, Question $question, Answer $answer)
    {
        $request->validate([
            'answer' => 'required',
            'validity' => 'nullable',
        ]);

        if (
            $question->answers()->where('valid', true)->first() &&
            $question->type === 'single' &&
            (int) $request->validity === 1 &&
            $answer->id !== $question->answers()->where('valid', true)->first()->id
        ) {
            return redirect()
                ->back()
                ->with('error', 'Une question a réponse unique ne peut pas avoir plusieurs réponses valide');
        }

        $answer->update([
            'text' => $request->answer,
            'valid' => $request->validity == 1 ? true : false,
        ]);

        return redirect()
            ->back()
            ->with('success', 'La réponse a été modifier.');
    }

    public function destroy(Question $question, Answer $answer)
    {
        $answer->delete();

        return redirect()
            ->back()
            ->with('success', 'La réponse a été supprimer.');
    }
}
