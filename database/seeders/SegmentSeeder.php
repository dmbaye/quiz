<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Segment::factory()->create(['name' => '7400']);
        \App\Models\Segment::factory()->create(['name' => '7414']);
        \App\Models\Segment::factory()->create(['name' => '37070']);
        \App\Models\Segment::factory()->create(['name' => '37171']);
    }
}
