<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class DashboardController extends Controller
{
    public function index(Request $request){
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : '';
        
        if($token !=''){
            // $user_id = auth()->user($tokan);
            return view('Admin/dashboard')->with(compact('token'));
        }else{
            return view('Admin/layouts/login/login');
        }
    }
}
