<?php
namespace App\Helpers; 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use Validator;
use DB;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index()
    {
        userLoggedIn();
        $settingData = DB::table('settings')->first();
        return view('Admin/settings/setting_form')->with(compact('settingData'));
    }

    public function saveSettings(Request $request){
        userLoggedIn();
        $validation = Validator::make($request->all(), [
            'ecApiKey'          => 'required',
            'version'           => 'required',            
        ]);
        if ($validation->fails()) {
            $ajaxResponse['status'] = 0;
            $ajaxResponse['error'] = $validation->errors()->all();
            echo json_encode($ajaxResponse);
            exit();
        }

        $settingData = $request->all();
        $ajaxResponse['status'] = 0;
        $ajaxResponse['msg'] = "Oops ! something went Wrong !..";
        $settingDataDB = Settings::all()->toArray();
        $isCreate = 1;
        if(empty($settingDataDB)) {
            $settingDataDB = new Settings;
        } else {
            $isCreate = 0;
            $settingDataDB = Settings::find($settingDataDB[0]['_id'])->first();
        } 
        $settingDataDB->ecapikey = $settingData['ecApiKey'];
        $settingDataDB->version = $settingData['version'];
        $settingDataDB->ec_region = $settingData['region'];
        if($isCreate == 1) {
            $settingDataDB->created_at = Carbon::now()->timestamp;
            $settingDataDB->save();
            $ajaxResponse['status'] = 1;
            $ajaxResponse['msg'] = "Settings save successfully";
        } else {
            $settingDataDB->updated_at = Carbon::now()->timestamp;
            $settingDataDB->update();    
            $ajaxResponse['status'] = 1;
            $ajaxResponse['msg'] = "Settings updated successfully";
        }
        echo json_encode($ajaxResponse);
        exit();
    }
}


