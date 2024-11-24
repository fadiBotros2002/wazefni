<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reports')->insert([
            [
                'user_id' => 3,
                'post_id' => 1,
                'message' => 'First report message',
                'is_read' => false,
                'status' =>"pending",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'post_id' => null,
                'message' => 'General report message',
                'is_read' => true,
                'status' =>"resolved",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
