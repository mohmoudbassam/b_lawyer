<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Experience::query()->create([
            'period' => '5-1',
        ]);
        Experience::query()->create([
            'period' => '10-5',
        ]);
        Experience::query()->create([
            'period' => '15-10',
        ]);
        Experience::query()->create([
            'period' => '20-15',
        ]);
        Experience::query()->create([
            'period' => '20+',
        ]);
    }
}
