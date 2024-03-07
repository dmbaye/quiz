<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $activeQuizzes = Quiz::active()->get();
        $upcomingQuizzes = Quiz::where('start_date', '>', \Carbon\Carbon::now())
            ->limit(5)
            ->get();

        return view('index', compact('activeQuizzes', 'upcomingQuizzes'));
    }
}
