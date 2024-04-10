<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email', 
        'password',
    ];
    
    public function phones()
    {
        return $this->hasOne(Phone::class, 'user_id');
    }
  
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    // Phương thức tạo mới người dùng
    public function store($data)
    {
        return $this->create($data);
    }

    // Hiển thị tất cả thông tin user
    public function getAllUsers()
    {
        return $this->with('phones')->get();
    }

    // Hiển thị thông tin của một người dùng cụ thể
    public function getUser($id)
    {
        return $this->with('phones')->find($id);
    }

    // Phương thức create new users
    public function addUser($userData, $phoneNumber = null)
    {
        $user = $this->create($userData);

        // Kiểm tra nếu có số điện thoại được gửi trong request
        if ($phoneNumber) {
            // Thêm số điện thoại cho người dùng vừa tạo mới
            $phone = new Phone(['number' => $phoneNumber]);
            $user->phones()->save($phone);
        }

        return $user->load('phones');
    }

    // Cập nhật thông tin của oneUser
    public function updateUser($id, $userData)
    {
        $user = $this->find($id);
        $user->update($userData);
        return $user;
    }

    // Phương thức xoá oneUser
    public function deleteUser($id)
    {
        $user = $this->find($id);
        $user->delete();
        return $user->with('phones')->get();
    }
}