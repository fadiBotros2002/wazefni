<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tests')->insert(
            [
                [
                    'title' => 'Test Title 1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Test Title 2',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Test Title 3',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
