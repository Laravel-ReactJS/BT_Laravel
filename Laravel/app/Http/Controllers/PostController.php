<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;

/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="Documentation for the API"
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     tags={"Posts"},
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new Post();
    }
    
    /*
        1. Get all posts from posts table
    */
    public function index()
    {
        $posts = $this->posts->getAllPosts();
        return response()->json($posts);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="The title of the post",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="The description of the post",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    /*
        2. Create new post
    */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:posts|min:5|max:100',
            'description' => 'required|min:10|max:50'
        ];
        $messages = [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
            'title.min' => 'Tiêu đề phải chứa ít nhất 5 ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 100 ký tự.',
            'description.required' => 'Mô tả là trường bắt buộc.',
            'description.min' => 'Mô tả phải chứa ít nhất 10 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 50 ký tự.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $data = $request->all();
        $addPost = DB::table('posts')->insert($data);
        return $addPost;
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a specific post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    /*
        3. Get one post by id
    */
    public function show($id)
    {
        $post = $this->posts->getOnePost($id);
        return response()->json($post);
    }

     /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update a specific post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="content", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    /*
        4. Update post by id
    */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|unique:posts|min:5|max:100',
            'description' => 'required|min:10|max:50'
        ];
        $messages = [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
            'title.min' => 'Tiêu đề phải chứa ít nhất 5 ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 100 ký tự.',
            'description.required' => 'Mô tả là trường bắt buộc.',
            'description.min' => 'Mô tả phải chứa ít nhất 10 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 50 ký tự.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $data = $request->all();
        $updatePost = DB::table('posts')->where('id', $id)->update($data);
        return $updatePost;
    }

     /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete a specific post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    
    /*
        5. Delete post by id
    */
    public function destroy($id)
    {
        $post = $this->posts->deletePost($id);
        if ($post) {
            return response()->json('sucess', 200);
        } else {
            return response()->json(['message' => 'Cannot delete'], 404);
        }
    }
}
