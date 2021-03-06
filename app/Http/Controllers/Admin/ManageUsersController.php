<?php

namespace App\Helpers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use App\Imports\UserDashboardImport;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;



class ManageUsersController extends Controller
{
    public function index(Request $request)
    {
        userLoggedIn();
        $allErrors = [];
        return view('Admin.manage_user.manage_user_list')->with(compact('allErrors'));
    }
    public function manageUsersSave(Request $request)
    {
        userLoggedIn();
        $validation = Validator::make($request->all(), [
            'userName' => 'required',
            // 'email' => 'required',
            // 'password' => 'required',
            'is_admin' => 'required',
            'status' => 'required',
        ]);
        $update_id = $request->input('userHdnID');
        if (empty($update_id)) {
            $validation->password = 'required';
            $validation->email   = 'required|email|unique:users';
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
        if ($update_id == '' && $update_id == null) {
            $insertData->name           = $userData['userName'];
            $insertData->email          = $userData['email'];
            $insertData->password       = Hash::make($userData['password']);
            $insertData->is_admin       = $userData['is_admin'];
            $insertData->status         = $userData['status'];
            $insertData->created_at     = Carbon::now()->timestamp;
            $insertData->save();
            $insert_id = $insertData->id;
            if ($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "User created Successfully";
                // $result['id'] = $insert_id;
            }
        } else {
            $updateDetails = User::where('_id', $update_id)->first();
            $updateDetails->name           = $userData['userName'];
            // $updateDetails->email          = $userData['email'];
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
        $allData = $request->all();
        $user_email = $allData['email'];
        $hid = $request->input('userHdnID');
        $find_user = User::where('email', '=', $user_email);
        if ($hid > 0) {
            $find_user->where('id', '!=', $hid);
        }
        $result = $find_user->count();

        if (isset($allData['forgot']) && $allData['forgot'] == 1 && $allData['forgot'] != '') {
            if ($result > 0) {
                echo json_encode(TRUE);
            } else {
                echo json_encode(FALSE);
            }
        } else {
            if ($result > 0) {
                echo json_encode(FALSE);
            } else {
                echo json_encode(TRUE);
            }
        }
    }

    public function manageUsersDataTable(Request $request)
    {
        userLoggedIn();
        
        if ($request->ajax()) {
            $data =  User::select('_id', 'name', 'email', 'is_admin', 'status')->where('_id','!=',logInUserData()['_id'])->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $rowStatus = isset($row->status) ? $row->status : '';
                    $status = "Inactive";
                    if ($rowStatus == 1) {
                        $status = "Active";
                    }
                    return $status;
                })
                ->addColumn('is_admin', function ($row) {
                    $rowAdmin = isset($row->is_admin) ? $row->is_admin : '';
                    $is_admin = "User";
                    if ($rowAdmin == 1) {
                        $is_admin = "Admin";
                    }
                    return $is_admin;
                })
                ->addColumn('action', function ($row) {
                    $action = '<input type="button" value="Delete" class="btn btn-sm btn-danger deleteUser" data-id="' . $row->_id . '" ">&nbsp;';
                    $action .= '<input type="button" value="Edit" class="btn btn-sm btn-primary editUser" data-id="' . $row->_id . '" ">';
                    return $action;
                })
                ->addColumn('dashboard', function ($row) {
                    $dashboard = "";
                    if ($row->is_admin != 1) {
                        $dashboard = '<a href="'.route("admin-userDashboard", ["id" => $row->_id]) . '" class="btn btn-warning text-light">Add</a>';
                    }
                    return $dashboard;
                    
                })
                ->rawColumns(['action', 'dashboard'])
                ->make(true);
        }
    }

    public function manageUsersEdit(Request $request)
    {
        userLoggedIn();
        $edit_id = $request->input('id');
        $responsearray = array();
        $responsearray['status'] = 0;
        if ($edit_id != '' && $edit_id != null) {
            $edit_sql = User::where('_id', $edit_id)->first();
            if ($edit_sql) {
                $responsearray['status'] = 1;
                $responsearray['userData'] = $edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }

    public function manageUsersDelete(Request $request)
    {
        userLoggedIn();
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! User Not Deleted !";
        if ($delete_id != '' && $delete_id != null) {
            $del_sql = User::where('_id', $delete_id)->delete();
            if ($del_sql) {
                $result['status'] = 1;
                $result['msg'] = "User Deleted Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    // public function dashboardDashboard(Request $request)
    // {
        

    //     $validator = Validator::make(
    //         [
    //             'file'      => $request->file,
    //             'extension' => strtolower($request->file->getClientOriginalExtension()),
    //         ],
    //         [
    //             'file'          => 'required',
    //             'extension'     => 'required|in:csv,xlsx',
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         $allErrors = $validator->errors()->all();
    //         return view('Admin.manage_user.manage_user_list')->with(compact('allErrors'));
    //     }

    //     Excel::import(new UserDashboardImport($request->userId), request()->file('file'));
    //     Session::flash('success', 'Products import successfully from csv.');
    //     return back();
    // }
}