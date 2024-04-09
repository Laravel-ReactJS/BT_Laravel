<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PersonsTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $peoples = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'random_date' => $faker->date,
                'status' => $faker->boolean,
                'photo' => $faker->imageUrl,
            ],
            [
                'name' => 'Nguyen Hoai',
                'email' => 'hoai@gmail.com',
                'password' => Hash::make('password123'),
                'random_date' => $faker->date,
                'status' => $faker->boolean,
                'photo' => $faker->imageUrl,
            ],
        ];

        foreach ($peoples as $people) {
            Person::create($people);
        }
    }
}
