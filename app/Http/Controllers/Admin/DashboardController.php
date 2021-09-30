<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Helper\Helper;

class DashboardController extends Controller
{
    public function index(Request $request){
        userLoggedIn();
        return view('Admin/dashboard');
    }
}
