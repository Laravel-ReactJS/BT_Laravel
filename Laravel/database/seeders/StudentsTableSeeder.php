<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;


class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = [
            [
                'name' => 'Phan Thang',
                'age' => '29',
                'location' => 'Phnom Penh',
            ],
            [
                'name' => 'Bui Anh Tuan',
                'age' => '26',
                'location' => 'Ho Chi Minh',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
