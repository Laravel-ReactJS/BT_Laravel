<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';

    public $timestamps = true;

    protected $fillable = ['title', 'description'];

    public function getAllPosts()
    {
        return DB::table('posts')->get();
    }

    public function getOnePost($id)
    {
        return DB::table('posts')->find($id);
    }

    public function addPost($data){
        return DB::table('posts')->insert($data);
    }
    public function showPost($id){
        return DB::table('posts')->where('id',$id)->get();
    }

    public function updatePost($id, $data){
        return DB::table('posts')->where('id', $id)->update($data);
    }
    public function deletePost($id){
        return DB::table('posts')->where('id', $id)->delete();
    }
}
