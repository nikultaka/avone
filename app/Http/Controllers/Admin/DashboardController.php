<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use app\Models\UserDashboard;
use Session;
use App\Helper\Helper;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        userLoggedIn();
        $numberOfUser = DB::table('users')->get()->count();
        $totalRegister = DB::table('users')->where('status',0)->get()->count();
         $titles = DB::table('users_dashboard')->select('title','_id','severity')->where('user_id',logInUserData()['_id'])->get()->toArray();
         $allDashboardData = DB::table('users_dashboard')->where('user_id',logInUserData()['_id'])->get()->toArray();

        return view('Admin.dashboard')->with(compact('numberOfUser','totalRegister','titles','allDashboardData'));
    }
}
