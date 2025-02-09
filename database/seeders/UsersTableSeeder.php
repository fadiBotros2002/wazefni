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
                'phone' => '0936985214',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'ahmad',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('123123123'),
                'role' => 'employer',
                'phone' => '0938641788',
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

            [
                'name' => 'jhone',
                'email' => 'jhone@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0938641715',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'assad',
                'email' => 'assad@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0934561779',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'mohammad',
                'email' => 'mohammad@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0931641779',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ali',
                'email' => 'ali@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0998641779',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'maya',
                'email' => 'maya@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0937771779',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'hiba',
                'email' => 'hiba@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0987961779',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'botros',
                'email' => 'botros@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0938641222',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'shadi',
                'email' => 'shadi@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0955444444',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],   [
                'name' => 'fayez',
                'email' => 'fayez@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0922222558',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],   [
                'name' => 'dany',
                'email' => 'dany@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0987545454',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],   [
                'name' => 'shaheen',
                'email' => 'shaheen@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => 'user',
                'phone' => '0987546223',
                'location'=>'syria',
                'userstatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}
