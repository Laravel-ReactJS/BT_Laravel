<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Models\Phone;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Yen',
                'email' => 'yen@gmail.com',
                'password' =>'12345678',
            ],
            [
                'name' => 'Hoai',
                'email' => 'hoai@gmail.com',
                'password' =>'password123',
            ],
        ];

        foreach ($users as $user) {
            $createdUser = Users::create($user);
            Phone::create([
                'number' => '098687656', 
                'user_id' => $createdUser->id,
            ]);
        }
    }
}
