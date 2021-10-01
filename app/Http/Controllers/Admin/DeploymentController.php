<?php
namespace App\Helpers; 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class DeploymentController extends Controller
{
    public function index(Request $request){
        userLoggedIn();
        return view('Admin/deployment/deployment_list');
    }

    public function deploymentDataTable(Request $request){  
        $requestData = $request->all();
        userLoggedIn();
        $token = getLoginAccessToken();
        $API_PREFIX = $request->urlbase;
        $ajaxResponse['status'] = 0;
        $encode_response = deploymentListApiCall($API_PREFIX,$token);
        if(isset($encode_response) && $encode_response !='' && $encode_response !=null){
            $deploymentsData = $encode_response->deployments;

            foreach ($deploymentsData as $key => $row) {
                $temp['id'] = $row->id;
                $temp['name'] = $row->name;
                $action = "<input type='button' value='Edit' class='btn btn-info editDeployment' data-id='".$row->id."'>&nbsp";
                $action .= "<input type='button' value='Delete' class='btn btn-danger deleteDeployment' data-id='".$row->id."'>";
                $temp['action'] = $action;
                $data[] = $temp;
            }
            $json_data = array(
                "draw" => intval($requestData['draw']),
                "data" => $data,
            );
            echo json_encode($json_data);
            exit();

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

    // public function deploymentDataTable(Request $request){  
    //     userLoggedIn();
    //     $token = getLoginAccessToken();
    //     $API_PREFIX = $request->urlbase;
    //     $ajaxResponse['status'] = 0;
    //     if ($request->ajax()) {
    //         $encode_response = deploymentListApiCall($API_PREFIX,$token);
    //         $data = $encode_response->deployments[0];
            
    //         return Datatables::of($data)
    //                 ->addIndexColumn()
    //                 // ->addColumn('status', function($row){   
    //                 //     $rowStatus = isset($row->status) ? $row->status : '';
    //                 //     $status = "Inactive";
    //                 //     if($rowStatus == 1){
    //                 //         $status = "Active";
    //                 //     }
    //                 //         return $status;
    //                 // })

    //                  ->addColumn('name', function($row){
    //                      echo '<pre>';
    //                      print_r($row);
    //                      die;
    //                     $rowStatus = isset($row->status) ? $row->status : '';
    //                     $status = "Inactive";
    //                     if($rowStatus == 1){
    //                         $status = "Active";
    //                     }
    //                         return $status;
    //                 })
                
    //                 ->addColumn('action', function($row){
    //                     $action = "<input type='button' value='Edit' class='btn btn-info editDeployment' data-id='".$row->id."'>";
    //                     $action .= "<input type='button' value='Delete' class='btn btn-danger deleteDeployment' data-id='".$row->id."'>";     
    //                     return $action;
    //                 })
    //                 ->rawColumns(['action','name','id'])
    //                 ->make(true);
    //     }
    // }

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
