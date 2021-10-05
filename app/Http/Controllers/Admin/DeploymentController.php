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

    public function changeStatusInfoAlert(Request $request){
        $deploymentListArrayHelper = deploymentListArrayHelper();      
        
        foreach($deploymentListArrayHelper as $deploymentListKey => $deploymentList){
            $lastStatus = $deploymentList['status'];
            $lastStatusChange = 0;
            if($lastStatus != $lastStatus){
                $lastStatusChange = 1;
                if($deploymentList['status'] == 1){                    
                    $ajaxResponse['deploymentStatus'] = 'Healthy';    
                }    
                $ajaxResponse['deploymentStatus'] = 'Pending';
                
            }
            
            $ajaxResponse['deploymentName'] = $deploymentList['name'];
            $ajaxResponse['lastStatus'] = $lastStatus;    
        }
    
        echo json_encode($ajaxResponse);
        exit;
    }

    public function deploymentDataTable(Request $request){  
        userLoggedIn();
        $token = getLoginAccessToken();
        $deploymentListArrayHelper = deploymentListArrayHelper();      
        $API_PREFIX = $request->urlbase;
        $ajaxResponse['status'] = 0;
        if ($request->ajax()) {
            $encode_response = deploymentListApiCall($API_PREFIX,$token);
            $data = [];
            if(!empty($encode_response) && $encode_response != '' && $encode_response != null){
                $data = $encode_response->deployments;
            }

            return Datatables::of($data)
                    ->addIndexColumn()
                    // ->addColumn('id', function($row){
                    //     $id = $row->id;
                    //     return $id;
                    //  })

                     ->addColumn('name', function($row){
                         $name = $row->name;
                         return $name;
                    })
                    ->addColumn('cloud_id', function($row){
                        if(userIsSuperAdmin()){
                            $cloud_id = $row->resources[0]->cloud_id;
                            return $cloud_id;
                        }
                   })
                   ->addColumn('deploymentStatus', function($row) use ($deploymentListArrayHelper) {  
                            $deploymentList = $deploymentListArrayHelper[$row->id];
                            $status = $deploymentList['status'];
                            if($status == 1){
                                $deploymentStatus = '<nobr><span class="healthy"><b>Healthy</b></span></nobr>';
                            }else{
                                $deploymentStatus = '<nobr><span class="pending"><b>Pending</b></span></nobr>';
                            }
                            return $deploymentStatus;
                    })
                   ->addColumn('kibanaLink', function($row) use ($deploymentListArrayHelper) {  
                            $kibanaAliasedUrl = $deploymentListArrayHelper[$row->id];
                            $kibanaLink = '<a href="'.$kibanaAliasedUrl['kibanaAliasedUrl'].'" target="_blank">'.$kibanaAliasedUrl['kibanaAliasedUrl'].'</a>';
                            return $kibanaLink;
                    })
                    ->addColumn('action', function($row){
                        $action = "<input type='button' value='Edit' class='btn btn-info editDeployment' data-id='".$row->id."'>&nbsp";
                        $action .= "<input type='button' value='Delete' class='btn btn-danger deleteDeployment' data-id='".$row->id."'>&nbsp";     
                        if(userIsSuperAdmin()){
                            $action .= "<input type='button' value='View' class='btn btn-success viewDeployment' data-id='".$row->id."'>";     
                        }
                        return $action;
                    })
                    ->rawColumns(['action','name','id','cloud_id','kibanaLink','deploymentStatus'])
                    ->make(true);
        }
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
