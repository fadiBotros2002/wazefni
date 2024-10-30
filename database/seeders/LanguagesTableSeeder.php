<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->insert(
            [
                [
                    'cv_id' => 1,
                    'language_name' => 'English',
                    'proficiency_level' => 'Fluent',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'cv_id' => 1,
                    'language_name' => 'French',
                    'proficiency_level' => 'Intermediate',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'cv_id' => 2,
                    'language_name' => 'Spanish',
                    'proficiency_level' => 'Advanced',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
