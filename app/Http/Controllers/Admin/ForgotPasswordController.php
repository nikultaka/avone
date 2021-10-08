<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Mail;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('Admin/layouts/login/forgot_password/enter_email');
    }

    public function sendMailToUser(Request $request)
    {
        
        $email = $request->email;
        $token = $request->_token;
        $this->validate($request, [
            'email'             => 'required|email',
        ], [
            'email.required'    => ' The Email field is required.',
        ]);
        if (!empty($email) && $email != '') {
            // if($UseremailData['userType'] == 'candidate'){
            $find_user = User::where('email', '=', $email)->first();
            if ($find_user != "" && $find_user != null) {
                $find_user->token =  $token;
                $find_user->save();
                $data = [
                    'subject'      => "Forgot Password",
                    'email'        => $email,
                    'token'        => $token,
                ];
                $data = Mail::send('Admin.layouts.login.forgot_password.forgot_password_template', ["userdata" => $data], function ($message) use ($data) {
                    $message->to($data['email'])
                        ->subject($data['subject']);
                });
                //echo '<pre>'; print_r($data); exit;
                return redirect('/login')->with('success', 'We send Password Re-set link in Your Register Account');
            } else {
                return redirect('/login')->with('error', 'User does not exist Regiser First!');
            }
        }
    }

    public function newPasswordView($token){
        $newpasswordtoken = $token;
        return view('Admin/layouts/login/forgot_password/new_password_view')->with(compact('newpasswordtoken'));
      }
  
      public function setNewPassword(Request $request){
        $this->validate($request,[
          'password'              => 'required|min:3|max:20',
          'confirm_password'      => 'required|min:3|max:20|same:password',
        ],[
          'passwoed.required'    => 'The password field is required.',
          'confirm_password.required'    => 'The Confirm Password field is required.',
          ]);
  
        $allData = $request->all();
        if(!empty($allData)){
        $find_user = User::where('token', '=', $allData['newpasswordtoken'])->first();
          if($find_user != '' && $find_user != null){
                if($allData['password'] == $allData['confirm_password']){
                  $find_user->password =  Hash::make($allData['password']);
                  $find_user->save(); 
                }else{
                  return back()->with('Password and confirm password does not match');
                }
            }
        }
        return redirect('/signin')->with('success','Your password Change successfully');
      }
}
