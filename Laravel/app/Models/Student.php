<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'age', 'location'];
    public function updateRow($id)
    {
        $students = DB::table('students')
            ->where('$id', $id)
            ->update([]);
        return $students;
    }
    public function getStudentsPhnomPenh()
    {
        $students = Student::where('location', 'Phnom Penh')
            ->where('age', '>', 20)
            ->get();
        return $students;
    }
}
