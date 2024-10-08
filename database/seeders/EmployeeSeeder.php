<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for ($i=0; $i < 5; $i++) { 
        //     $imagePath = fake()->image(null, 640, 480, null, false);
        //     $imageData = file_get_contents($imagePath);

        //     Employee::query()->create([
        //         'first_name'        => fake()->firstName,
        //         'last_name'         => fake()->lastName,
        //         'email'             => fake()->unique()->email,
        //         'phone'             => fake()->phoneNumber,
        //         'date_of_birth'     => fake()->date(),
        //         'hire_date'         => now(),
        //         'is_active'         => rand(0,1),
        //         'address'           => fake()->address,
        //         'profile_picture'   => $imageData,
        //     ]);
        // }
    }
}
