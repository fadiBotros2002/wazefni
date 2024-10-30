<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ExperiencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('experiences')->insert(
            [
                [
                    'cv_id' => 1,
                    'company_name' => 'Tech Corp',
                    'domain' => 'Software Development',
                    'job_description' => 'Developed web applications using Laravel and Vue.js.',
                    'start_date' => '2020-01-01',
                    'end_date' => '2021-12-31',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'cv_id' => 2,
                    'company_name' => 'Marketing Experts',
                    'domain' => 'Digital Marketing',
                    'job_description' => 'Led digital marketing campaigns across multiple platforms.',
                    'start_date' => '2019-03-01',
                    'end_date' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]

            ]
        );
    }
}
