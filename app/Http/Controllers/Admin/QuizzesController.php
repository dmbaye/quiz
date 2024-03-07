<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Role;
use App\Models\User;
use App\Models\Segment;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizzesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $quizzes = [];
        $archivedQuizzes = Quiz::archived()->paginate(10);

        if (isset($request->search)) {
            $search = $request->search;

            $quizzes = Quiz::active()
                ->where('name', 'LIKE', $search . '%')
                ->orWhereHas('users', function ($query) use ($search) {
                    $query->where('name', 'LIKE', $search . '%');
                })
                ->paginate(25);
        } else {
            $quizzes = Quiz::active()->latest()->paginate(25);
        }

        return view('admin.quizzes.index', compact('quizzes', 'archivedQuizzes', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|exists:categories,id',
            'name' => 'required',
            'date' => 'required',
            'objective' => 'required',
            'duration' => 'required',
            'description' => 'nullable|string'
        ]);

        $quiz = Quiz::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->date,
            'objective' => $request->objective,
            'duration' => $request->duration,
        ]);

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('success', 'Le quiz a été ajouter.');
    }

    public function show(Request $request, Quiz $quiz)
    {
        $categories = Category::all();
        $roles = Role::whereNotIn('name', ['superadmin', 'admin'])->get();
        $segments = Segment::all();
        $users = $this->searchAssignedUsers($request, $quiz);
        $allUsers = $this->searchUnassignedUsers($request, $quiz);

        return view('admin.quizzes.show', compact('quiz', 'roles', 'users', 'allUsers', 'segments', 'categories'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'category' => 'required|exists:categories,id',
            'name' => 'required',
            'date' => 'required',
            'objective' => 'required',
            'duration' => 'required',
            'description' => 'nullable|string'
        ]);

        $quiz = $quiz->update([
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->date,
            'objective' => $request->objective,
            'duration' => $request->duration,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Le quiz a été modifier.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->back();
    }

    public function searchAssignedUsers(Request $request, Quiz $quiz)
    {
        $users = [];

        if (isset($request->assigned)) {
            $users = $quiz->users()
                ->where('name', 'LIKE', '%' . $request->assigned . '%')
                ->orWhere('username', 'LIKE', '%' . $request->assigned . '%')
                ->paginate(25);
        } else {
            $users = $quiz->users()->paginate(25);
        }

        return $users;
    }

    public function searchUnassignedUsers(Request $request, Quiz $quiz)
    {
        $users = [];

        if (isset($request->non_assigned)) {
            $ids = $quiz->users->pluck('id');

            $users = User::active()
                ->where('name', 'LIKE', '%' . $request->non_assigned . '%')
                ->orWhere('username', 'LIKE', '%' . $request->non_assigned . '%')
                ->whereHasRole(['supervisor', 'backoffice', 'trainee', 'user'])
                ->whereNotIn('id', $ids)
                ->paginate(25);
        } else {
            $ids = $quiz->users->pluck('id');

            $users = User::active()
                ->whereHasRole(['supervisor', 'backoffice', 'trainee', 'user'])
                ->whereNotIn('id', $ids)
                ->paginate(25);
        }

        return $users;
    }
}
