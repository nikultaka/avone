<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DeploymentController extends Controller
{
    public function index(Request $request){
        return view('Admin/deployment/deployment_list');
    }

    public function deploymentDataTable(Request $request){  
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : '';
        $API_PREFIX = $request->urlbase;
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => $API_PREFIX.'/api/deployment/list',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSLVERSION=> 0,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token.''
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);        
        $ajaxResponse['status'] = 0;
        $encode_response = json_decode($response);
        if(isset($encode_response) && $encode_response !='' && $encode_response !=null){
            $deploymentsData = $encode_response->deployments;
            $ajaxResponse['status'] = 1;
            $table = '<tr><td colspan="3" style="text-align: center;">No record found</td></tr>';
            foreach($deploymentsData as $val){
                $table = '<tr><td>'.$val->id.'</td>'
                    . '<td>'.$val->name.'</td>'
                    . "<td><button class='btn btn-info' data-toggle='tooltip' title='Edit deployment' onclick='edit_deployment(" . $val->id . ")'>Edit</button>
                    <input type='button' value='Delete' class='btn btn-danger deleteDeployment' data-id='".$val->id."'></td></tr>";
            }
            // . "<td><button class='btn btn-info' data-toggle='tooltip' title='Edit deployment' onclick='edit_deployment(" . $val->id . ")'>Edit</button>
            // <button class='btn btn-danger' data-toggle='tooltip' title='Edit deployment' onclick='delete_deployment(" . $val->id . ")'>Delete</button></td></tr>";
            $ajaxResponse['table'] = $table;
        }
    
        echo json_encode($ajaxResponse);
        exit;
         
    }
}
