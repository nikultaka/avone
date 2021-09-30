<?php
namespace App\Helpers; 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DeploymentController extends Controller
{
    public function index(Request $request){
        userLoggedIn();
        return view('Admin/deployment/deployment_list');
    }

    public function deploymentDataTable(Request $request){  
        userLoggedIn();
        $token = getLoginAccessToken();
        $API_PREFIX = $request->urlbase;
        $ajaxResponse['status'] = 0;
        $encode_response = deploymentListApiCall($API_PREFIX,$token);
        if(isset($encode_response) && $encode_response !='' && $encode_response !=null){
            $deploymentsData = $encode_response->deployments;
            $ajaxResponse['status'] = 1;
            $table = '<tr><td colspan="3" style="text-align: center;">No record found</td></tr>';
            foreach($deploymentsData as $val){
                $table = '<tr><td>'.$val->id.'</td>'
                    . '<td>'.$val->name.'</td>'
                    . "<td><input type='button' value='Edit' class='btn btn-info editDeployment' data-id='".$val->id."'>
                           <input type='button' value='Delete' class='btn btn-danger deleteDeployment' data-id='".$val->id."'>
                       </td></tr>";
            }
            $ajaxResponse['table'] = $table;
        }
        echo json_encode($ajaxResponse);
        exit; 
    }

    public function deploymentEdit(Request $request){  
        userLoggedIn();
        $token = getLoginAccessToken();
        $API_PREFIX = $request->urlbase;
        $deploymentID = $request->deploymentID;
        $ajaxResponse['status'] = 0;
        $encode_response = '';
        $encode_response = deploymentViewApiCall($API_PREFIX,$token,$deploymentID);
        if(!empty($encode_response) && $encode_response !='' && $encode_response !=null){
            $ajaxResponse['status'] = 1;
            $ajaxResponse['deploymentsEditData'] = $encode_response;
        }
        echo json_encode($ajaxResponse);
        exit; 
    }

   
}
