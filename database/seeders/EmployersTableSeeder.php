<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EmployersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employers')->insert(
            [
                [
                    'user_id' => 2,

                    'company_name' => 'Tech Innovators',
                    'company_description' => 'Leading the way in tech innovation and development.',
                    'verification_documents' =>null,
                    'created_at' => now(),
                    'updated_at' => now(),

                ],

            ]
        );
    }
}
