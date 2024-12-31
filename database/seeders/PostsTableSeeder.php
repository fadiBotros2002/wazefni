<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'user_id' => 2,
                'title' => 'Software Developer',
                'type' => 'Full-time',
                'description' => 'Develop and maintain web applications.',
                'requirement' => 'Experience in Laravel and Vue.js.',
                'location' => 'Remote',
                'time' => '9 AM to 5 PM',
                'salary' => '60000',
                'experience_year' => 3,

                'posted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Project Manager',
                'type' => 'Contract',
                'description' => 'Manage software development projects.',
                'requirement' => 'PMP certification and 5 years of experience.',
                'location' => 'On-site',
                'time' => 'Flexible',
                'salary' => '80000',
                'experience_year' => 5,

                'posted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
