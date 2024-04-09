<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostController extends Controller
{
    public function getPost()
    {
        $posts = DB::table('posts')->find(4);
        // dd($posts);
        return $posts;
    }
}
