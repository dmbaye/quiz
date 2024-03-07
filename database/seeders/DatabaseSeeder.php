<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(SegmentSeeder::class);
        $this->call(CategorySeeder::class);

        \App\Models\Category::factory()->create([
            'name' => 'Non catégorisé',
        ]);

        $superAdmin = \App\Models\User::factory()->create([
            'name' => 'Djibril M\'Baye',
            'username' => 'dmbaye',
            'email' => 'dmbaye@app.com',
        ]);

        $superAdmin->addRole('superadmin');
    }
}
