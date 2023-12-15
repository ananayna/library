<?php

namespace Database\Seeders;

use App\Models\Student\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = new Student();
        $student->name = "Student";
        $student->email = "student@gmail.com";
        $student->password = Hash::make('123456789');
        $student->save();
    }
}
