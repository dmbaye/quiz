<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function update(User $user)
    {
        $user->update(['is_active' => true]);

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->update(['is_active' => false]);

        return redirect()->back();
    }
}
