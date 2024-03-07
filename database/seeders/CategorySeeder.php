<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Category::create(['name' => 'Offres']);
        \App\Models\Category::create(['name' => 'Services']);
        \App\Models\Category::create(['name' => 'Orange Money']);
        \App\Models\Category::create(['name' => 'Promo']);
    }
}
