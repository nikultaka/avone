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

    public function index(Request $request,$action)  
    {
        if($action == 'list') {
            $data = curlCall('GET','deployments'); 
            return response()->json($data, 201);    
        } else if($action == 'create') {
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
        } else if($action == 'update') {
            $deploymentID = $request->header('deploymentID');
            $data = json_decode(file_get_contents('php://input'));
            $arrayData = (array)$data;
            $validator = Validator::make($arrayData, [
                'name' => 'required|string',
            ]);
            if(!$validator->fails()) {
                $jsonString = $request->json()->all();
                $json = json_encode($jsonString);
                $data = curlCall('PUT','deployments/'.$deploymentID,$json); 
                return response()->json($data, 201);
            } else {
                return response()->json($validator->errors(), 422);
            }
        } else if($action == 'delete') {
            $deploymentID = $request->header('deploymentID');
            if($deploymentID!='') {
                $jsonString = $request->json()->all();
                $json = json_encode($jsonString);
                $data = curlCall('POST','deployments/'.$deploymentID.'/_shutdown',$json); 
                return response()->json($data, 201);
            } else {
                return response()->json(array('error'=>"DeploymentID is missing"), 422);
            }    
        } else if($action == 'view'){
            $deploymentID = $request->header('deploymentID');
            if($deploymentID!='') {
                $jsonString = $request->json()->all();
                $json = json_encode($jsonString);
                $data = curlCall('GET','deployments/'.$deploymentID,$json); 
                return response()->json($data, 201);
            } else {
                return response()->json(array('error'=>"DeploymentID is missing"), 422);
            }    
        }
    }
}
