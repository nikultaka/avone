<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function index(){
    	return view('Admin/layouts/login/register');
    }

    public function activeUserAccount($id)
    {
        $find_user = User::where('id', $id)->first();
            if ($find_user->status != '1') {
                $find_user->status = '1';
                $find_user->updated_at = Carbon::now();
                $find_user->save();
                if ($find_user) {
                    return redirect('/signin')->with('success', 'Your account has been activated Successfully..');
                }
            } else {
                return redirect('/signin')->with('error', 'Your account already activated.');
            }
    }
}