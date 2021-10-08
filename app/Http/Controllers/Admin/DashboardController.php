<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use app\Models\User;
use Session;
use App\Helper\Helper;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        userLoggedIn();
        $numberOfUser = DB::table('users')->get()->count();
        $totalRegister = DB::table('users')->where('status',0)->get()->count();
        
        return view('Admin/dashboard')->with(compact('numberOfUser','totalRegister'));
    }
}
