<?php

namespace App\Http\Controllers\Admin;

use App\Models\Segment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SegmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $segments = Segment::all();

        return view('settings.segments.index', compact('segments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:segments,name',
            'description' => 'sometimes',
        ]);

        Segment::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()
            ->with('success', 'Le plateau a été ajouter.');
    }

    public function update(Request $request, Segment $segment)
    {
        $request->validate([
            'name' => 'required|unique:segments,name',
            'description' => 'sometimes',
        ]);

        $segment->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()
            ->with('success', 'Le plateau a été modifier.');
    }

    public function destroy(Segment $segment)
    {
        $segment->delete();

        return redirect()->back()
            ->with('success', 'Le plateau a été supprimer.');
    }
}
