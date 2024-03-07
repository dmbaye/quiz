<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Mot de passe réinitialiser. Reconnectez-vous.');
    }
}
