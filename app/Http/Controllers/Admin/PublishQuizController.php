<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublishQuizController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function update(Request $request, Quiz $quiz)
    {
        $quiz->update([
            'is_published' => true,
        ]);

        return redirect()->back()
            ->with('success', 'Le quiz a été publier.');
    }
}
