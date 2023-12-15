<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //Profile Page
    public function index(){
        return view('student.profile.student_profile');
    }
}
