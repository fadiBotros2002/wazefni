<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert(
            [
                [
                    'question_text' => 'What is the capital of France?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'question_text' => 'What is 2 + 2?',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
