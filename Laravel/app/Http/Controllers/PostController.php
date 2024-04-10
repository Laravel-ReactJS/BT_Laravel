<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Models\Users;

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
        // Lấy tất cả các bài viết cùng với thông tin về người dùng tạo ra bài viết
        $posts = Post::with('users')->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
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
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id', // Ensure the user exists
        ]);

        // Create a new post
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $request->user_id;

        // Save the post
        $post->save();

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'Post created successfully.'
        ], 201);
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
        // Lấy thông tin của người dùng
        $user = Users::with('posts')->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404); // 404: Not Found
        }

        // Trả về thông tin của người dùng và danh sách các bài viết của người dùng đó
        return response()->json([
            'success' => true,
            'data' => $user,
        ], 200);
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

        $validator = Validator::make($request->all());
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
