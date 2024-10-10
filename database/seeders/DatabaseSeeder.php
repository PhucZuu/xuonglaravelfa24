<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Classroom;
use App\Models\Comment;
use App\Models\Phone;
use App\Models\Post;
use App\Models\Role;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // for ($i=1; $i <= 5; $i++) { 
        //     Classroom::create([
        //         'name' => 'Class ' . $i,
        //         'teacher_name' => 'Teacher ' . $i,
        //     ]);
        // }

        // for ($i = 1; $i <= 10; $i++) {
        //     Subject::create([
        //         'name' => 'Subject ' . $i,
        //         'credits' => rand(1, 10),
        //     ]);
        // }

        // for ($i = 0; $i < 10; $i++) {
        //     Role::create([
        //         'role' => fake()->text(10)
        //     ]);
        // }


        // for ($i=0; $i < 10; $i++) { 
        //     Post::create([
        //         'title' => fake()->text(100)
        //     ]);
        // }

        // for ($i=1; $i < 11; $i++) { 
        //     Comment::create([
        //         'post_id' => $i,
        //         'content' => fake()->text
        //     ]);
        // }

        // for ($i=1; $i < 11; $i++) { 
        //     Comment::create([
        //         'post_id' => $i,
        //         'content' => fake()->text
        //     ]);
        // }

        // for ($i=1; $i < 11; $i++) { 
        //     Comment::create([
        //         'post_id' => $i,
        //         'content' => fake()->text
        //     ]);
        // }

        // $users = User::pluck('id')->all();

        // foreach ($users as $id) {
        //     Phone::query()->create([
        //         'user_id' => $id,
        //         'value' => fake()->unique()->phoneNumber()
        //     ]);
        // }
        // \App\Models\User::factory(1000)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
