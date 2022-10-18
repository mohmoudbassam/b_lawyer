<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => [
                'ar' => 'عضوية شهرية',
                'en' => 'Monthly Membership'
            ],
            'description' => 'Monthly',
            'price' => 500,
            'type' => 1,
        ]);
        Plan::create([
            'name' => [
                'ar' => 'عضوية نصف سنوية',
                'en' => 'Half Yearly Membership'
            ],
            'description' => 'Monthly',
            'price' => 1500,
            'type' => 2,
        ]);
        Plan::create([
            'name' => [
                'ar' => 'عضوية سنوية',
                'en' => 'Yearly Membership'
            ],
            'description' => 'Monthly',
            'price' => 2800,
            'type' => 3,
        ]);
    }
}
