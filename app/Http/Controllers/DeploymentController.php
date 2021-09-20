<?php

namespace App\Helpers;
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class DeploymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $data = curlCall('GET','deployments'); 
        //return $data;
        return response()->json($data, 201);
    }

    public function store(Request $request)
    {
        $jsonString = $request->json()->all();
        $json = json_encode($jsonString);
        $data = curlCall('POST','deployments',$json); 
        return response()->json($data, 201);
    }
}
