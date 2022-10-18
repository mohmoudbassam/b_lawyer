<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\LawyerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::query()->create([
            'name' => [
                'ar' => 'الفاهرة',
                'en' => 'Cairo',
            ],
        ]);
        City::query()->create([
            'name' => [
                'ar' => 'الإسكندرية',
                'en' => 'Alexandria',
            ],
        ]);
        City::query()->create([
            'name' => [
                'ar' => 'منوفيه',
                'en' => 'Menoufia',
            ],
        ]);
        LawyerType::query()->create([
            'name' => [
                'ar' => 'محامي اداري ',
                'en' => 'Administrative',
            ],
        ]);
        LawyerType::query()->create([
            'name' => [
                'ar' => 'محامي جنائي',
                'en' => 'Criminal',
            ],
        ]);
        LawyerType::query()->create([
            'name' => [
                'ar' => 'محامي عقاري',
                'en' => 'Real Estate',
            ],
        ]);
        LawyerType::query()->create([
            'name' => [
                'ar' => 'محامي عام',
                'en' => 'General',
            ],
        ]);
        LawyerType::query()->create([
            'name' => [
                'ar' => 'محامي اسري',
                'en' => 'Family',
            ],
        ]);
        LawyerType::query()->create([
            'name' => [
                'ar' => 'محامي تجاري',
                'en' => 'Commercial',
            ],
        ]);
        LawyerType::query()->create([
            'name' => [
                'ar' => ' مجلس قضايا اداريةومجلس دولة',
                'en' => 'Administrative and State Council',
            ],
        ]);
    }
}
