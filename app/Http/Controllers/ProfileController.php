<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('auth.profile.show');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        auth()->user()->update([
            'name' => $request->name,
        ]);

        return redirect()->back()
            ->with('success', 'Vos informations ont été mise à jour.');
    }
}
