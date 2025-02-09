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
        DB::table('questions')->insert([
            [
                'question_text' => 'Tell Me About Yourself',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Why Are You Interested in This Position',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'What Motivates You?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'What Are Your Career Goals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'How Would You Describe Yourself in Three Words',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Why do you want to work here?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'What do you know about our company?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'What are your salary expectations?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'What are your availability dates?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Are you willing to relocate or travel?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'What is your biggest professional accomplishment?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Tell me about a time you failed.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Describe a time you had to deal with a difficult coworker',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'How do you handle stress and pressure?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Give an example of a time you had to work under a tight deadline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Tell me about a time you had to make a difficult decision.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Why should we hire you?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'What is your ideal work environment?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Why did you leave your last job?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question_text' => 'Where do you see yourself after 5 years?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
