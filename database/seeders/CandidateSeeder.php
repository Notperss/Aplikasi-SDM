<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recruitment\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // Create 50 candidates using the factory
        Candidate::factory()->count(50)->create();
    }
}
