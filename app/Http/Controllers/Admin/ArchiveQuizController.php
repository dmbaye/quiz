<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Http\Controllers\Controller;

class ArchiveQuizController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function update(Quiz $quiz)
    {
        $quiz->update([
            'is_archived' => true,
        ]);

        return redirect()->back()
            ->with('success', 'Le quiz a été archiver.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->update([
            'is_archived' => false,
        ]);

        return redirect()->back()
            ->with('success', 'Le quiz a été désarchiver.');
    }
}
