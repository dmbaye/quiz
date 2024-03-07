<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class ImportUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $reader = new Csv();

        $spreadsheet = $reader->load($request->file);

        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $item) {
            $user = User::create([
                'segment_id' => $item[4],
                'name' => $item[0],
                'username' => $item[1],
                'email' => $item[2],
                'password' => Hash::make('C@llme2024'),
            ]);

            $role = Role::findOrFail($item[3]);

            $user->addRole($role);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'Les utilisateurs ont été ajouter.');
    }
}
