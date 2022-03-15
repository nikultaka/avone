<?php
namespace App\Helpers; 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Deployment;
use Symfony\Component\HttpFoundation\Session\Session;
use Carbon\Carbon;
use Validator;

class DeploymentController extends Controller
{
    private $deploymentPrivate;

    public function index(Request $request){
        userLoggedIn();
        return view('Admin/deployment/deployment_list');
    }

    public function deploymentInsert(Request $request){
        userLoggedIn();
        $validation = Validator::make($request->all(), [
            'deploymentName' => 'required',
            'sizePerZoneElastic' => 'required',
            'availabilityZonesElastic' => 'required',
            'sizePerZoneKibana' => 'required',
            'availabilityZonesKibana' => 'required',
            'sizePerZoneApm' => 'required',
            'availabilityZonesApm' => 'required',
        ]);
        $update_id = $request->input('deploymentHdnID');        
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['msg'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }

        $deploymentData = $request->all();
        $result['status'] = 2;
        $result['msg'] = "Something went wrong please try again";
        $insertData = new Deployment;
        if($update_id == '' && $update_id == null){
            $insertData->deploymentID                   = $deploymentData['deploymentID'];
            $insertData->deploymentName                 = $deploymentData['deploymentName'];
            $insertData->sizePerZoneElastic             = $deploymentData['sizePerZoneElastic'];
            $insertData->availabilityZonesElastic       = $deploymentData['availabilityZonesElastic'];
            $insertData->sizePerZoneKibana              = $deploymentData['sizePerZoneKibana'];
            $insertData->availabilityZonesKibana        = $deploymentData['availabilityZonesKibana'];
            $insertData->sizePerZoneApm                 = $deploymentData['sizePerZoneApm'];
            $insertData->availabilityZonesApm           = $deploymentData['availabilityZonesApm'];
            $insertData->status                         = '';
            $insertData->created_at                     = Carbon::now()->timestamp;
            $insertData->save();
            $insert_id = $insertData->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Deployments created successfully";
                // $result['id'] = $insert_id;
            }
        }else{
            $updateDetails = Deployment::where('deploymentID',$update_id)->first();
            $updateDetails->deploymentName                 = $deploymentData['deploymentName'];
            $updateDetails->sizePerZoneElastic             = $deploymentData['sizePerZoneElastic'];
            $updateDetails->availabilityZonesElastic       = $deploymentData['availabilityZonesElastic'];
            $updateDetails->sizePerZoneKibana              = $deploymentData['sizePerZoneKibana'];
            $updateDetails->availabilityZonesKibana        = $deploymentData['availabilityZonesKibana'];
            $updateDetails->sizePerZoneApm                 = $deploymentData['sizePerZoneApm'];
            $updateDetails->availabilityZonesApm           = $deploymentData['availabilityZonesApm'];
            // $updateDetails->status                         = '';
            $updateDetails->updated_at                     = Carbon::now()->timestamp;
            $updateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Deployments updated successfully";
        }
        echo json_encode($result);
        exit;
    }

    function deploymentDelete(Request $request)
    {
        $delete_id = $request->input('deploymentID');
        
        $result['status'] = 0;
        $result['msg'] = "Oops ! Deployments not Deleted !";
        if ($delete_id != '' && $delete_id != null) {
            $del_sql = Deployment::where('deploymentID', $delete_id)->delete();
            if ($del_sql) {
                $result['status'] = 1;
                $result['msg'] = "Deployments Delete successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function deploymentDataTable(Request $request){  
        userLoggedIn();
        $token = getLoginAccessToken();
        $API_PREFIX = $request->urlbase;
        $deploymentListArrayHelper = deploymentListArrayHelper($API_PREFIX,$token);      
        
        $request->session()->forget('deploymentList');
        $request->session()->put('deploymentList', $deploymentListArrayHelper);


        
        $ajaxResponse['status'] = 0;
        if ($request->ajax()) {
            $encode_response = deploymentListApiCall($API_PREFIX,$token);

            $data = [];
            if(isset($encode_response) && $encode_response != '' && $encode_response != null){
                $data = $encode_response->deployments;
            }

            return Datatables::of($data)
                    ->addIndexColumn()
                    
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
                            $kibanaLink = '<a href="https://api.elastic-cloud.com/'.$kibanaAliasedUrl['kibanaAliasedUrl'].'" style="margin-left: 50px;" target="_blank" data-toggle="tooltip" title="Open Link"><i class="text-center fas fa-external-link-alt"></i></a>';
                            return $kibanaLink;
                    })
                    ->addColumn('action', function($row) use ($deploymentListArrayHelper){
                        $deploymentList = $deploymentListArrayHelper[$row->id];
                        $status = $deploymentList['status'];
                        if($status == 1){ 
                            $action = "<input type='button' value='Edit' data-toggle='tooltip' title='Edit Deployment' class='btn btn-info editDeployment' data-id='".$row->id."'>&nbsp";
                        }else{
                            $action = "<input disabled type='button' value='Edit' data-toggle='tooltip' title='Edit Deployment' class='btn btn-info' data-id='".$row->id."'>&nbsp";
                        }
                        
                        $action .= "<input type='button' value='Delete' data-toggle='tooltip' title='Delete Deployment' class='btn btn-danger deleteDeployment' data-id='".$row->id."'>&nbsp";     
                        if(userIsSuperAdmin()){
                            $action .= "<input type='button' value='View' class='viewDeployment btn btn-success data-toggle='tooltip' title='View Deployment Data'  data-id='".$row->id."'>";     
                        }
                        return $action;
                    })
                    ->rawColumns(['action','name','id','cloud_id','kibanaLink','deploymentStatus'])
                    ->make(true);
        }
    }

    
    public function changeStatusInfoAlert(Request $request){
        $token = getLoginAccessToken();
        $API_PREFIX = $request->urlbase;
        $deploymentListArrayHelper = deploymentListArrayHelper($API_PREFIX,$token);              
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
        //$encode_response = deploymentViewApiCall($API_PREFIX,$token,$deploymentID);
        $encode_response = curlCall('GET','deployments/'.$deploymentID,array());  
        if(!empty($encode_response) && $encode_response !='' && $encode_response !=null){
            $ajaxResponse['status'] = 1;
            $ajaxResponse['deploymentsEditData'] = $encode_response;
        }
        echo json_encode($ajaxResponse);
        exit; 
    }

    

   
}
