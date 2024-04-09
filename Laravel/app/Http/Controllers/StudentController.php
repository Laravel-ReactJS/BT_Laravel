<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    private $students;

    public function __construct()
    {
        $this->students = new Student();
    }

    public function index(){
        return $this->students->getStudentsPhnomPenh();
    }

    public function updateRow(){
        $student = Student::find(1);
        if($student) {
            $student->update([
                'name' => 'Phan Thang',
                'age' => 1,
                'location' => "Phnom Penh"
            ]);
        }
    }
    public function deleteRow(){
        $student = Student::find(26);
        if($student) {
            $student->delete();
        }
        else {
            return "Không tồn tại";
        }
    }
}