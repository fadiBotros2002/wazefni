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
            [
                'user_id' => 3,
                'title' => 'Accountant',
                'type' => 'Contract',
                'description' => 'We are looking for a reliable Accountant to join our team. The ideal candidate should have excellent accounting skills and experience with financial software.',
                'requirement' => 'Accounting degree, experience with financial software, good communication skills, and attention to detail.',
                'location' => 'Syria_baghdad street',
                'time' => 'Full-time',
                'salary' => '3000 per month',
                'experience_year' => 3,
                'posted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'title' => 'Business Manager',
                'type' => 'Contract',
                'description' => 'We are looking for a Business Manager to join our team. The ideal candidate should have excellent leadership skills and experience in managing business operations.',
                'requirement' => 'Business degree, experience in management, good communication skills, and the ability to lead a team.',
                'location' => 'Syria_ Business Center',
                'time' => 'Full-time',
                'salary' => '4000 per month',
                'experience_year' => 5,
                'posted_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
