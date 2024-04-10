<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="Tên API",
 *     version="1.0.0",
 *     description="Mô tả API"
 * )
 */
class UserController extends Controller
{

    private $users;
    public function __construct()
    {
        $this->users = new Users();
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        // Lấy tất cả dữ liệu từ bảng users và phones
        $users = $this->users->getAllUsers();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="The name of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="The email of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *           @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="The password of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(Request $request)
    {
        $userData = $request->only(['name', 'email', 'password']);
        $user = $this->users->addUser($userData, $request->input('number'));
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
    
    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get a specific user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function show($id)
    {
        $user = $this->users->getUser($id);
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update a specific user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="The name of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="The email of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function update(Request $request, $id)
    {
        $userData = $request->only(['name', 'email', 'password']);
        $user = $this->users->updateUser($id, $userData);

        // Kiểm tra và cập nhật số điện thoại nếu có
        if ($request->has('number')) {
            $phone = $user->phones()->firstOrCreate(['user_id' => $user->id]);
            $phone->update(['number' => $request->input('number')]);
        }
        
        // Lấy lại thông tin người dùng sau khi cập nhật kèm theo số điện thoại
        $user = $user->fresh();

        // Thêm thông tin số điện thoại vào mảng dữ liệu người dùng
        $userData['phone'] = $user->phones()->value('number');

        return response()->json([
            'success' => true,
            'data' => $userData
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete a specific user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy($id)
    {
        $user = $this->users->deleteUser($id);
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}