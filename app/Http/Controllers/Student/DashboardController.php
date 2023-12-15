<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Dashoboard Page
    public function index()
    {
        return view('student.dashboard');
    }
}
