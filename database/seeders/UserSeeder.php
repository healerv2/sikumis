<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = array(
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123'),
                'foto' => 'user.jpg',
                'nik' => '350000000000',
                'phone' => '085000000000',
                'usia' => '29',
                'level' => 1
            ],
            [
                'name' => 'ibu hamil 1',
                'email' => 'ibu@gmail.com',
                'password' => bcrypt('123'),
                'foto' => 'user.jpg',
                'nik' => '350000000000',
                'phone' => '085000000000',
                'usia' => '25',
                'level' => 2
            ]
        );

        array_map(function (array $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }, $users);
    }
}
