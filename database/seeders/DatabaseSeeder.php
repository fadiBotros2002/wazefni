<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*
            User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
            */



        $this->call(
            [
                UsersTableSeeder::class,
                TestsTableSeeder::class,
                PostsTableSeeder::class,
                ReportsTableSeeder::class,
                ApplicationsTableSeeder::class,
                NotificationsTableSeeder::class,
                CVsTableSeeder::class,
                LanguagesTableSeeder::class,
                ExperiencesTableSeeder::class,
                QuestionsTableSeeder::class,
                EmployersTableSeeder::class,
                AnswersTableSeeder::class,

            ]
        );
    }
}
