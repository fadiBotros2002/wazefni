<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'fadib',
                'email' => 'fadib@example.com',
                'password' => Hash::make('123123123'),
                'role' => 'admin',
                'phone' => '0938641779',
                'location'=>'syria/saydnaya',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'joy',
                'email' => 'joy@example.com',
                'password' => Hash::make('123123123'),
                'role' => 'employer',
                'phone' => '0938641779',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'ahmad',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0938641779',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'fadi',
                'email' => 'fadibotros99@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0938641779',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}
