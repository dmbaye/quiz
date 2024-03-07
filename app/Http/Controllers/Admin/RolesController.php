<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $roles = Role::whereNotIn('name', ['superadmin', 'admin'])->orderBy('display_name', 'ASC')->get();
        $permissions = Permission::all();

        return view('settings.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create([
            'name' => Str::slug($request->role),
            'display_name' => $request->role,
            'description' => $request->description,
        ]);

        $role->givePermissions($request->permissions);

        return redirect()
            ->back()
            ->with('success', 'Le rôle a été ajouter.');
    }
}
