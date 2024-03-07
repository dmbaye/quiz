<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Segment;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request): View
    {
        $users = [];
        $inactiveUsers = [];
        $roles = Role::whereNotIn('name', ['superadmin', 'admin'])->get();
        $segments = Segment::all();

        if (isset($request->search)) {
            $users = User::active()
                ->whereHas('roles', function ($query) {
                    $query->whereNotIn('name', ['superadmin', 'admin']);
                })
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('username', 'LIKE', '%' . $request->search . '%')
                ->paginate(15);

            $inactiveUsers = User::inactive()
                ->whereHas('roles', function ($query) {
                    $query->whereNotIn('name', ['superadmin', 'admin']);
                })
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('username', 'LIKE', '%' . $request->search . '%')
                ->paginate(15);
        } else {
            $users = User::active()
                ->whereHas('roles', function ($query) {
                    $query->whereNotIn('name', ['superadmin', 'admin']);
                })
                ->orderBy('username', 'ASC')
                ->paginate(15);

            $inactiveUsers = User::inactive()
                ->whereHas('roles', function ($query) {
                    $query->whereNotIn('name', ['superadmin', 'admin']);
                })
                ->orderBy('username', 'ASC')
                ->paginate(15);
        }

        return view('settings.users.index', compact('users', 'inactiveUsers', 'roles', 'segments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'segment' => 'nullable|exists:segments,id',
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'role' => 'required',
        ]);

        $user = User::create([
            'segment_id' => $request->segment,
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make('Callme2023'),
        ]);

        $user->addRole($request->role);

        return redirect()
            ->back()
            ->with('success', 'Le nouvel utilisateur a été ajouter.');
    }

    public function show(User $user): View
    {
        $roles = Role::whereNotIn('name', ['superadmin', 'admin'])->get();

        return view('settings.users.show', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'segment' => 'nullable|exists:segments,id',
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'role' => 'nullable',
        ]);

        $user->update([
            'segment_id' => $request->segment,
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        $user->syncRolesWithoutDetaching([$request->role]);

        return redirect()
            ->back()
            ->with('success', 'L\'utilisateur a été modifier.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'L\'utilisateur a été supprimer.');
    }
}
