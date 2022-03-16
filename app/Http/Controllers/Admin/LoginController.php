<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class LoginController extends Controller
{
    public function index()
    {
        // if(userLoggedIn()){
        //     $numberOfUser = DB::table('users')->get()->count();
        //     $totalRegister = DB::table('users')->where('status',0)->get()->count();
        
        // return view('Admin/dashboard')->with(compact('numberOfUser','totalRegister'));
        // }else{
        //     return view('Admin/layouts/login/login');
        // }

        return view('Admin/layouts/login/login');
        
    }

    public function logout(Request $request){
        setcookie("userName", "", time() - 3600);
        setcookie("access_token", "", time() - 3600);
        setcookie("is_admin", "", time() - 3600);
        setcookie("user_id", "", time() - 3600);
        
        $response['status'] = 1;
        echo json_encode($response);
        exit;
    }

    
    // public function loginProccess(Request $request)
    // {
    //     $email = $request->email;
    //     $password = $request->password;
    //     $this->validate($request, [
    //         'email'   => 'required|email',
    //         'password' => 'required|min:6'
    //     ]);

        
    //     $curl = curl_init();
    //     curl_setopt_array($curl, array( 
    //         CURLOPT_URL => 'http://127.0.0.1:8000/api/auth/login',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => 'email='.$email.'&password='.$password,
    //         CURLOPT_HTTPHEADER => array(
    //             'Content-Type: application/x-www-form-urlencoded'
    //         ),
    //     ));
    //     $response = curl_exec($curl); 
    //     $result = json_decode($response, true);
    //     curl_close($curl);
        
    // }
}
