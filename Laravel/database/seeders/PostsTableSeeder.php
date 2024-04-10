<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Users;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = Users::all();
        if ($users->isEmpty()) {
            return;
        }
        
        $items = [
            ['title' => 'BirthDay', 'description' => 'Happy birthday'],
            ['title' => 'Valentine', 'description' => 'Valentine Happy'],
        ];

        foreach ($items as $item) {
            // Chọn một người dùng ngẫu nhiên từ danh sách người dùng
            $randomUser = $users->random();

            // Tạo một bài viết mới và gán các giá trị từ mảng $item
            $post = new Post();
            $post->title = $item['title'];
            $post->description = $item['description'];

            // Liên kết bài viết với người dùng được chọn ngẫu nhiên
            $post->user_id = $randomUser->id;
            $post->save();
        }
    }
}