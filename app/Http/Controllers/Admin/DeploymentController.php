<?php
namespace App\Helpers; 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Symfony\Component\HttpFoundation\Session\Session;


class DeploymentController extends Controller
{
    private $deploymentPrivate;

    public function index(Request $request){
        userLoggedIn();
        return view('Admin/deployment/deployment_list');
    }


    public function deploymentDataTable(Request $request){  
        userLoggedIn();
        $token = getLoginAccessToken();
        $deploymentListArrayHelper = deploymentListArrayHelper();      

        $request->session()->forget('deploymentList');
        $request->session()->put('deploymentList', $deploymentListArrayHelper);
        
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
                            $kibanaLink = '<a href="'.$kibanaAliasedUrl['kibanaAliasedUrl'].'" style="margin-left: 50px;" target="_blank" data-toggle="tooltip" title="Open Link"><i class="text-center fas fa-external-link-alt"></i></a>';
                            return $kibanaLink;
                    })
                    ->addColumn('action', function($row){
                        $action = "<input type='button' value='Edit' data-toggle='tooltip' title='Edit Deployment' class='btn btn-info editDeployment' data-id='".$row->id."'>&nbsp";
                        $action .= "<input type='button' value='Delete' data-toggle='tooltip' title='Delete Deployment' class='btn btn-danger deleteDeployment' data-id='".$row->id."'>&nbsp";     
                        if(userIsSuperAdmin()){
                            $action .= "<input type='button' value='View' class='btn btn-success data-toggle='tooltip' title='View Deployment Data' viewDeployment' data-id='".$row->id."'>";     
                        }
                        return $action;
                    })
                    ->rawColumns(['action','name','id','cloud_id','kibanaLink','deploymentStatus'])
                    ->make(true);
        }
    }

    
    public function changeStatusInfoAlert(Request $request){

        $deploymentListArrayHelper = deploymentListArrayHelper();              
        $deploymentWithNewKey = array();
            foreach($deploymentListArrayHelper as $deploymentList ){
                $deploymentWithNewKey[]  = recursive_change_key($deploymentList, array('name' => 'name_'.$deploymentList['id'].'', 'status' => 'status_'.$deploymentList['id'].''));
            }
            $lastStatusChange = 0;
            $oldDeploymentList = $request->session()->get('deploymentList');
            
            foreach($oldDeploymentList as $aV){
                $aTmp1[$aV['id']] = $aV['status'];
            }
            
            foreach($deploymentWithNewKey as $aV){
                $aTmp2[$aV['id']] = $aV['status_'.$aV['id']];
            }

            $result=array_keys(array_diff($aTmp1,$aTmp2));      

            $lastStatusChange = 0;
            if(count($result) > 0){
                 foreach($result as $array_diff_key => $array_diff_val){
                     $changDataId = $array_diff_val;
                     $deploymentWithAllData[] = $deploymentListArrayHelper[$changDataId];  
                 }
                 
                 $changedDeployment = array();
                 foreach($deploymentWithAllData as $deploymentWithData){
                      $changedDeployment[] =  array('id' => $deploymentWithData['id'], 
                                                       'name' => $deploymentWithData['name'],
                                                       'status' => $deploymentWithData['status'],
                                                     );     
                 }

                $lastStatusChange = 1;
                $ajaxResponse['changedDeployment'] = $changedDeployment;
            }
            $ajaxResponse['lastStatusChange'] = $lastStatusChange;    
        
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
