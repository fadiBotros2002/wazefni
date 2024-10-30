<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notifications')->insert(
            [
                [
                    'post_id' => 1,
                    'user_id' => 3,
                    'application_id' => 1,
                    'message' => 'Your application has been accepted.',
                    'sent_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'post_id' => 2,
                    'user_id' => 4,
                    'application_id' => 2,
                    'message' => 'Your application has been rejected.',
                    'sent_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ]
        );
    }
}
