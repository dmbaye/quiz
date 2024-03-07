<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'group' => 'required',
            'segment' => 'sometimes',
        ]);

        $users = [];

        if ($request->segment) {
            $users = User::active()
                ->whereHasRole($request->group)
                ->where('segment_id', $request->segment)
                ->where('is_active', 1)
                ->get();
        } else {
            $users = User::active()
                ->whereHasRole($request->group)
                ->where('is_active', 1)
                ->get();
        }

        if (count($users) === 0) {
            return redirect()->back()
                ->with('error', 'Aucun utilisateur trouvez.');
        }

        foreach ($users as $user) {
            if (! $user->quizzes()->where($quiz->id)) {
                $user->quizzes()->attach($quiz->id);
            }

            $user->questions()->detach($quiz->questions()->pluck('id')->all());
            $user->quizzes()->detach($quiz->id);
            $user->quizzes()->attach($quiz->id);
        }

        return redirect()->back()
            ->with('success', 'Le quiz a été assigner.');
    }

    public function single(Quiz $quiz, User $user)
    {
        if ($user->quizzes()->where('quiz_id', $quiz->id)->first()) {
            return redirect()->back()
                ->with('warning', "Le quiz est deja assigner à l'utilisateur \"{$user->name}\"");
        }

        $user->quizzes()->attach($quiz->id);

        return redirect()->back()
            ->with('success', 'Le quiz a été assigner à ' . $user->name);
    }

    public function update(Quiz $quiz, User $user)
    {
        if ($user->quizzes()->where($quiz->id)) {
            $user->questions()->detach($quiz->questions()->pluck('id')->all());
            $user->quizzes()->detach($quiz->id);
        }

        $user->quizzes()->attach($quiz->id);

        return redirect()->back()
            ->with('success', 'Le quiz a été réassigner à ' . $user->name);
    }

    public function destroy(Quiz $quiz, User $user)
    {
        $user->questions()->detach($quiz->questions()->pluck('id')->all());
        $user->quizzes()->detach($quiz->id);

        return redirect()->back()
            ->with('success', "Le quiz a été déassigner de \"{$user->name}\"");
    }
}
