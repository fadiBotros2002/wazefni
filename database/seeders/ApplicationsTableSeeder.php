<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            DB::table('applications')->insert([
                [
                    'post_id' => 1,
                    'user_id' => 3,
                    'cv' => 'cv1.pdf',
                    'test_result' => '80',
                    'status' =>'pending',
                    'application_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],


            ]);
        }
    }
}
