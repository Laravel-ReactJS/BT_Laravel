<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['title' => 'BirthDay', 'description' => 'Happy birthday'],
            ['title' => 'Valentine', 'description' => 'Valinetine Happy'],
        ];
        foreach ($items as $item){
            Post::create($item);
        }
    }
}