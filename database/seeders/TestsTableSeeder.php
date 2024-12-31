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
                    'user_id' => 2,
                    'result' => 70.0,
                    'status' => 'completed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
