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
                    'test_id' => 1,
                    'question' => 'Where do you see yourself in five years?',
                    'options' => json_encode(['Leading a team', 'In a different industry', 'Still at this company', 'Other']),
                    'answer' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'test_id' => 1,
                    'question' => 'Can you describe a time when you faced a challenge at work and how you overcame it?',
                    'options' => json_encode(['Yes', 'No']),
                    'answer' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'test_id' => 1,
                    'question' => 'Why do you want to work here?',
                    'options' => json_encode(['Culture', 'Career growth', 'Job role', 'Other']),
                    'answer' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'test_id' => 2,
                    'question' => 'What are your strengths and weaknesses?',
                    'options' => json_encode(['Strengths', 'Weaknesses', 'Both', 'Other']),
                    'answer' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'test_id' => 2,
                    'question' => 'How do you handle stress and pressure?',
                    'options' => json_encode(['Very well', 'Well', 'Average', 'Poorly']),
                    'answer' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
