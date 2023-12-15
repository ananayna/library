<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //Profile Page
    public function index(){
        return view('admin.profile.admin_profile');
    }
}
