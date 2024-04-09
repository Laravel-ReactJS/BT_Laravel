<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Post;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                'title' => 'Good morning',
                'description' => 'Good morning',
                'status' => true,
            ],
            [
                'title' => 'Good afternoon',
                'description' => 'Good afternoon',
                'status' => false,
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
