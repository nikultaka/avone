<?php
namespace App\Helpers; 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use DataTables;


class ManageUsersController extends Controller
{
    public function index(Request $request){
        userLoggedIn();
        return view('Admin/manage_user/manage_user_list');
    }
    public function manageUsersSave(Request $request){  
        userLoggedIn();
        $validation = Validator::make($request->all(), [
            'userName' => 'required',
            // 'userEmail' => 'required',
            // 'password' => 'required',
            'is_admin' => 'required',
            'status' => 'required',
        ]);
        $update_id = $request->input('userHdnID');        
        if(empty($update_id)){
            $validation->password = 'required';
            $validation->adminuserEmailemail   = 'required|email|unique:users';
        }
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }

        $userData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Something went wrong please try again";
        $insertData = new User;
        if($update_id == '' && $update_id == null){
            $insertData->name           = $userData['userName'];
            $insertData->email          = $userData['userEmail'];
            $insertData->password       = Hash::make($userData['password']);
            $insertData->is_admin       = $userData['is_admin'];
            $insertData->status         = $userData['status'];
            $insertData->created_at     = Carbon::now()->timestamp;
            $insertData->save();
            $insert_id = $insertData->id;
            if($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "User created Successfully";
                // $result['id'] = $insert_id;
            }
        }else{
            $updateDetails = User::where('_id',$update_id)->first();
            $updateDetails->name           = $userData['userName'];
            // $updateDetails->email          = $userData['userEmail'];
            $updateDetails->password       = !empty($userData['password']) ? Hash::make($userData['password']) : $updateDetails->password;
            $updateDetails->is_admin       = $userData['is_admin'];
            $updateDetails->status         = $userData['status'];
            $insertData->updated_at        = Carbon::now()->timestamp;
            $updateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "User Data Update Successfully!";
        }
        echo json_encode($result);
        exit;
    }

    public function emailExistOrNot(Request $request)
	{
        $email = $request->all();
        $user_email = $email['userEmail'];
        $hid = $request->input('userHdnID');
        $find_user = User::where('email', '=', $user_email);  
        if ($hid > 0) {
            $find_user->where('id', '!=', $hid);
        }
        $result = $find_user->count();
		if ($result > 0) {
			echo json_encode(FALSE);
		} else {
			echo json_encode(true);
		}
	}

    public function manageUsersDataTable(Request $request){  
        userLoggedIn();
        if ($request->ajax()) {
             $data =  User::select('_id','name','email','is_admin','status')->get();

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
                    ->addColumn('is_admin', function($row){   
                        $rowAdmin = isset($row->is_admin) ? $row->is_admin : '';
                        $is_admin = "User";
                        if($rowAdmin == 1){
                            $is_admin = "Admin";
                        }
                        return $is_admin;
                    })
                    ->addColumn('action', function($row){
                        $action = '<input type="button" value="Delete" class="btn btn-danger deleteUser" data-id="'. $row->_id .'" ">';
                        $action .= '  <input type="button" value="Edit" class="btn btn-primary editUser" data-id="'. $row->_id . '" ">';     
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function manageUsersEdit(Request $request){  
        userLoggedIn();
        $edit_id = $request->input('id');
        $responsearray = array(); 
        $responsearray['status'] = 0;
        if($edit_id != '' && $edit_id != null){
            $edit_sql = User::where('_id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['userData']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
        
    }

    public function manageUsersDelete(Request $request){  
        userLoggedIn();
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! User Not Deleted !";
        if($delete_id != '' && $delete_id != null){
            $del_sql = User::where('_id',$delete_id)->delete();
            if($del_sql){
                $result['status'] = 1;
                $result['msg'] = "User Deleted Successfully";
              }
        }
        echo json_encode($result);
        exit;
    }


   
}
