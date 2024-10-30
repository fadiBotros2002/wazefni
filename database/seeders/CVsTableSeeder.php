<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CVsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cvs')->insert(
            [
                [
                    'user_id' => 3,
                    'image' => 'image1.jpg',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'john.doe@example.com',
                    'phone_number' => '123-456-7890',
                    'domain' => 'Software Engineering',
                    'education' => 'B.Sc. in Computer Science',
                    'city' => 'San Francisco',
                    'address' => '123 Main St',
                    'portfolio' => 'http://johndoeportfolio.com',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => 4,
                    'image' => 'image2.jpg',
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'email' => 'jane.smith@example.com',
                    'phone_number' => '098-765-4321',
                    'domain' => 'Marketing',
                    'education' => 'M.A. in Marketing',
                    'city' => 'New York',
                    'address' => '456 Market St',
                    'portfolio' => 'http://janesmithportfolio.com',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
