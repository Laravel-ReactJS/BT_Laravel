<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'status'];

    protected $hidden = ['updated_at'];
    protected $casts = [
        'created_at' => 'date:d, l F Y',
        'status' => 'boolean',
    ];
}
