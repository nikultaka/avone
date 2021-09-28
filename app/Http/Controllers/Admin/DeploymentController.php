<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DeploymentController extends Controller
{
    public function index(Request $request){
        return view('Admin/deployment/deployment_list');
    }
}
