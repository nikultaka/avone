<?php

namespace App\Helpers; 
namespace App\Http\Controllers;
//namespace App\Http\Controllers\Api;


use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response; 
use App\Http\Controllers\Api\Responseobject; 

class DeploymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $data = curlCall('GET','deployments'); 
        return response()->json($data, 201);
    }

    public function store(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'));
        $arrayData = (array)$data;
        $validator = Validator::make($arrayData, [
            'name' => 'required|string',
        ]);
        if(!$validator->fails()) {
            $jsonString = $request->json()->all();
            $json = json_encode($jsonString);
            $data = curlCall('POST','deployments',$json); 
            return response()->json($data, 201);
        } else {
            return response()->json($validator->errors(), 422);
        }
    }
}
