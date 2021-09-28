<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class DashboardController extends Controller
{
    public function index(Request $request){
        $tokan = $_GET['access_token'];
        if($tokan !=''){
            // $user_id = auth()->user($tokan);
            return view('Admin/dashboard')->with(compact('tokan'));
        }else{
            return view('Admin/layouts/login/login');
        }
    }
}
