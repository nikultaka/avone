<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use App\Models\Cms;
use Illuminate\Support\Facades\Hash;
use DB;
use DataTables;
use Validator;
use Datetime;
use DateTimeZone;


class CmsController extends Controller
{
    public function index()
    {
        return view('Admin/cms/cmslist');
    }


    public function addCms(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title'             => 'required',
            'slug'              => 'required|unique:cms',
            'description'       => 'required',
        ]);
        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }
        $update_id = $request->input('hid');
        $CmsData = $request->all();
        $result['status'] = 0;
        $result['msg'] = "Please enter valid data";
        $cms = new Cms();
        if ($update_id == '' && $update_id == null) {
            $cms->title             = $CmsData['title'];
            $cms->slug              = $CmsData['slug'];
            $cms->descriptioneditor = $CmsData['description'];
            $cms->metatitle         = $CmsData['metatitle'];
            $cms->metakeyword       = $CmsData['metakeyword'];
            $cms->metadescription   = $CmsData['metadescription'];
            $cms->status            = $CmsData['status'];
            $cms->save();
            // $insert_id = $cms->_id;
            if ($cms) {
                $result['status'] = 1;
                $result['msg'] = "CMS created successfully";
            }
        } else {
            $UpdateDetails = Cms::where('_id', $update_id)->first();
            $UpdateDetails->title             = $CmsData['title'];
            $UpdateDetails->slug              = $CmsData['slug'];
            $UpdateDetails->descriptioneditor = $CmsData['description'];
            $UpdateDetails->metatitle         = $CmsData['metatitle'];
            $UpdateDetails->metakeyword       = $CmsData['metakeyword'];
            $UpdateDetails->metadescription   = $CmsData['metadescription'];
            $UpdateDetails->status            = $CmsData['status'];
            $UpdateDetails->save();
            $result['status'] = 1;
            $result['msg'] = "CMS Updated successfully";
        }

        echo json_encode($result);
        exit;
    }

    // public function cmslist()
    // {
    //     return view('Admin/cms/cmslist');
    // }
    public function cmsDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Cms::select('_id', 'title', 'slug', 'status')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = "Inactive";
                    if ($row->status == 1) {
                        $status = "Active";
                    }
                    return $status;
                })
                // ->addColumn('created_at', function($row){   
                //     $utc = $row->created_at;
                //     $dt = new DateTime($utc);
                //     $tz = new DateTimeZone('Asia/Kolkata');
                //     $dt->setTimezone($tz);
                //     $old_date = $dt->format('Y-m-d H:i:s');
                //     $new_date = date("d-F-Y", strtotime($old_date));
                //     return $new_date;

                // })
                ->addColumn('action', function ($row) {
                    $action = '<input type="button" value="Delete" class="btn btn-danger delete_cms" data-id="' . $row->_id . '">&nbsp';
                    $action .= '<input type="button" value="Edit" class="btn btn-info edit_cms" data-id="' . $row->_id . '">';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    function deleteCmsData(Request $request)
    {
        $delete_id = $request->input('id');
        $result['status'] = 0;
        $result['msg'] = "Oops ! Cms not Deleted !";
        if (!empty($delete_id)) {
            $del_sql = Cms::where('_id', $delete_id)->delete();
            if ($del_sql) {
                $result['status'] = 1;
                $result['msg'] = "Cms Deleted Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }

    public function editCmsData(Request $request){
        $edit_id = $request->input('id');   

        $responsearray = array(); 
        $responsearray['status'] = 0;
        if(!empty($edit_id)){
            $edit_sql = Cms::where('_id',$edit_id)->first();
            if($edit_sql){
                $responsearray['status'] = 1;
                $responsearray['cms']=$edit_sql;
            }
        }
        echo json_encode($responsearray);
        exit;
    }
    public function checkSlug(Request $request)
    {
        $slug = $request->input('slug');
        $hid = $request->input('hid');
        $checkslug = Cms::where('slug', '=', $slug);
        if ($hid > 0) {
            $checkslug->where('id', '!=', $hid);
        }
        $checkslugcount = $checkslug->count();
        if ($checkslugcount > 0) {
            echo json_encode(FALSE);
        } else {
            echo json_encode(TRUE);
        }
    }
}
