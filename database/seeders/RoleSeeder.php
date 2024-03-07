<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create(['name' => 'superadmin', 'display_name' => 'Super Admin']);
        \App\Models\Role::create(['name' => 'admin', 'display_name' => 'Admin']);
        \App\Models\Role::create(['name' => 'trainer', 'display_name' => 'Formateur']);
        \App\Models\Role::create(['name' => 'supervisor', 'display_name' => 'Superviseur']);
        \App\Models\Role::create(['name' => 'backoffice', 'display_name' => 'Back Office']);
        \App\Models\Role::create(['name' => 'qa', 'display_name' => 'Qualité']);
        \App\Models\Role::create(['name' => 'trainee', 'display_name' => 'Immersion']);
        \App\Models\Role::create(['name' => 'user', 'display_name' => 'Conseiller']);
    }
}
