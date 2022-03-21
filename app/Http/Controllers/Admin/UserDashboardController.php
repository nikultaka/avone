<?php

namespace App\Helpers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserDashboard;
use Validator;
use DataTables;

class UserDashboardController extends Controller
{
    public function index($id)
    {
        userLoggedIn();
        $dashboardList =  UserDashboard::where('user_id',$id)->get()->toArray();
        return view('Admin.manage_user.user_dashboard')->with(compact('id','dashboardList'));
    }
    
    public function save(Request $request){
        userLoggedIn();
        $result['status'] = 0;
        $result['msg'] = "Something went wrong please try again";
        $update_id = $request->recordId;
        $insertData = new UserDashboard;
        if ($update_id == '' || $update_id == null) {
            $insertData->user_id                         = $request->userId;
            $insertData->title                           = $request->title;
            $insertData->network_assessment_findings     = $request->networkAssessmentFindings;
            $insertData->severity                        = $request->severity;
            $insertData->cve_cwe                         = $request->cve_cwe;
            $insertData->cvss3                           = $request->cvss3;
            $insertData->description                     = $request->description;
            $insertData->buisness_impact                 = $request->buisnessImpact;
            $insertData->published_exploit               = $request->publishedExploit;
            $insertData->recommendation                  = $request->recommendation;
            $insertData->monitor_your_threat             = $request->monitorYourThreat;
            $insertData->save();
            $insert_id = $insertData->id;
            if ($insert_id > 0) {
                $result['status'] = 1;
                $result['msg'] = "User dashboard data save Successfully";
            }
        } else {
            $updateData = UserDashboard::where('_id', $update_id)->first();
            $updateData->user_id                         = $request->userId;
            $updateData->title                           = $request->title;
            $updateData->network_assessment_findings     = $request->networkAssessmentFindings;
            $updateData->severity                        = $request->severity;
            $updateData->cve_cwe                         = $request->cve_cwe;
            $updateData->cvss3                           = $request->cvss3;
            $updateData->description                     = $request->description;
            $updateData->buisness_impact                 = $request->buisnessImpact;
            $updateData->published_exploit               = $request->publishedExploit;
            $updateData->recommendation                  = $request->recommendation;
            $updateData->monitor_your_threat             = $request->monitorYourThreat;
            $updateData->save();
            $updateData->save();
            $result['status'] = 1;
            $result['msg'] = "User dashboard data Update Successfully!";
        }
        echo json_encode($result);
        exit;   
    }

    public function delete(Request $request){
        userLoggedIn();
        $result['status'] = 0;
        $result['msg'] = "Oops ! Not Deleted !";
        if ($request->id != '' && $request->id != null) {
            $del_sql = UserDashboard::where('_id', $request->id)->delete();
            if ($del_sql) {
                $result['status'] = 1;
                $result['msg'] = "Deleted Successfully";
            }
        }
        echo json_encode($result);
        exit;
    }
}