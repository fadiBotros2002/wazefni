<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('answers')->insert(
            [

                [
                    'user_id' => 2,
                    'test_id' => 1,
                    'question_id' => 2,
                    'audio_path' => 'path/to/audio2.mp3',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
