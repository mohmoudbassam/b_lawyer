<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name' => 'admin',
            'phone' => '0597400254',
            'email'=>'mamhoud@test.com',
            'password' => bcrypt('123456'),
            'type' => 'user',
            'enabled' => 1,
            'enabled_to' => now()->addMonths(3)->toDateString(),
        ]);
        User::query()->create([
            'name' => 'admin',
            'phone' => '00',
            'email'=>'mamhosud@test.com',
            'password' => bcrypt('123456'),
            'type' => 'lawyer',
            'enabled' => 1,
            'enabled_to' => now()->addMonths(3)->toDateString(),
        ]);
        $office=User::query()->create([
            'name' => 'lawyer',
            'phone' => '20',
            'email'=>'mamhmud@test.com',
            'password' => bcrypt('123456'),
            'type' => 'office',
            'enabled' => 1,
            'enabled_to' => now()->addMonths(3)->toDateString(),
        ]);
        $office1=User::query()->create([
            'name' => 'lawyerOffice',
            'phone' => '30',
            'email'=>'mamhmudd@test.com',
            'password' => bcrypt('123456'),
            'type' => 'office',
            'enabled' => 1,
            'enabled_to' => now()->addMonths(3)->toDateString(),
        ]);
        $office->office_type()->attach([1,2]);
        $office1->office_type()->attach([3,2]);

    }
}
