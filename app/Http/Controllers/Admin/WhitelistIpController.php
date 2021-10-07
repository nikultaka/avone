<?php
namespace App\Helpers; 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WhitelistIp;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use DataTables;


class WhitelistIpController extends Controller
{
    public function index(Request $request){
        userLoggedIn();
        return view('Admin/whitelist_ip/whitelist_ip_list');
    }
    public function whitelistIpSave(Request $request){  
        userLoggedIn();
        $validation = Validator::make($request->all(), [
            'ipName' => 'required',
            'status' => 'required',
        ]);
        $update_id = $request->input('ipHdnID');        
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $ipData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Something went wrong please try again";
        $insertData = new WhitelistIp;
        if($update_id == '' && $update_id == null){
            $insertData->ip_name           = $ipData['ipName'];
            $insertData->status         = $ipData['status'];
            $insertData->created_at     = Carbon::now()->timestamp;
            $insertData->save();
            $insert_id = $insertData->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "Ip created Successfully";
                // $result['id'] = $insert_id;
            }
        }else{
            $updateDetails = WhitelistIp::where('_id',$update_id)->first();
            $updateDetails->ip_name           = $ipData['ipName'];
            $updateDetails->status         = $ipData['status'];
            $insertData->updated_at        = Carbon::now()->timestamp;
            $updateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "Ip Update Successfully!";
        }
        echo json_encode($result);
        exit;
    }

    public function whitelistIpDataTable(Request $request){  
        userLoggedIn();
        if ($request->ajax()) {
            
            $data =  WhitelistIp::select('_id','ip_name','status')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($row){   
                        $rowStatus = isset($row->status) ? $row->status : '';
                        $status = "Inactive";
                        if($rowStatus == 1){
                            $status = "Active";
                        }
                            return $status;
                    })
                    ->addColumn('action', function($row){
                        $action = '<input type="button" value="Delete" class="btn btn-danger deleteIp" data-id="'. $row->_id .'" ">';
                        $action .= '<input type="button" value="Edit" class="btn btn-primary editIp" data-id="'. $row->_id . '" ">';     
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function whitelistIpEdit(Request $request){  
        userLoggedIn();
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        if($edit_id != '' && $edit_id != null){
            $edit_sql = WhitelistIp::where('_id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['ipData']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
        
    }

    public function whitelistIpDelete(Request $request){  
        userLoggedIn();
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! User Not Deleted !";
        if($delete_id != '' && $delete_id != null){
            $del_sql = WhitelistIp::where('_id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "User Deleted Successfully";
              }
        }
        echo json_encode($result);
        exit;
    }
}
