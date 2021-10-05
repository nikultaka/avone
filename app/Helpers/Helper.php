<?php

if (!function_exists('curlCall')) {
    function curlCall($method,$path,$postdata=''){
        $curl = curl_init();
        curl_setopt_array($curl, array(
              CURLOPT_URL => env("API_URL").$path,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => $method,
              CURLOPT_POSTFIELDS => $postdata,
              CURLOPT_SSLVERSION=> 0,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_HTTPHEADER => array(
                'Authorization: ApiKey '.config('app.EC_API_KEY'),
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        // $error_msg = curl_error($curl);
        //     echo '<pre>';
        //     print_r($error_msg);
        //     die;
        curl_close($curl);
        return json_decode($response);
    }
}

function deploymentWithNewKeyOddHelper($array=''){
    
    return $array;
}
function recursive_change_key($arr, $set) {
    if (is_array($arr) && is_array($set)) {
        $newArr = array();
        foreach ($arr as $k => $v) {
            $key = array_key_exists( $k, $set) ? $set[$k] : $k;
            $newArr[$key] = is_array($v) ? recursive_change_key($v, $set) : $v;
        }
        return $newArr;
    }
    return $arr;    
}

// _________________________________________________________ Deployment list api call function______________________________________________________________

if (!function_exists('deploymentListArrayHelper')) {
    function deploymentListArrayHelper(){
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : '';    
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://127.0.0.1:8001/api/deployment/list',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token.''
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $deploymentsDataArray = array();
        
        if($response != '' && $response != null && !empty($response)){
            $json_decode_response = json_decode($response)->deployments;
        }
        if(!empty($json_decode_response) && $json_decode_response != '' && $json_decode_response != null){
                $deploymentsIdAndNameArray = array();            
                foreach($json_decode_response as $key => $deploymentList){
                    $deploymentsIdAndNameArray[] =  array('id' => $deploymentList->id, 'name' => $deploymentList->name);
                }
            
                if(count($deploymentsIdAndNameArray) > 0){
                    foreach($deploymentsIdAndNameArray as $deploymentsIdAndNameKey => $deploymentsIdAndName){
                        $deploymentsId = $deploymentsIdAndName['id'];
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'http://127.0.0.1:8001/api/deployment/view',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_HTTPHEADER => array(
                                    'Authorization: Bearer '.$token.'',
                                    'deploymentID: '.$deploymentsId.''
                                ),
                            ));
                            $responseViewApi = curl_exec($curl);
                            curl_close($curl);
                            $json_decode_response_view = json_decode($responseViewApi);                               
                            
                            if($json_decode_response_view->healthy != '' && $json_decode_response_view->healthy != ''){
                                    $planElasticSearchArray = $json_decode_response_view->resources->elasticsearch[0]->info->plan_info->current->plan->cluster_topology;
                                    $currentPlanElasticSearch = '';
                                        foreach($planElasticSearchArray as $planElasticSearch){
                                            if($planElasticSearch->size->value != 0){
                                                $currentPlanElasticSearch = $planElasticSearch;
                                            }
                                        }
                                    $currentPlanElasticSearchSize = $currentPlanElasticSearch->size->value;
                                    $currentPlanElasticSearchZone = $currentPlanElasticSearch->zone_count;
                                       
                                
                                    if($json_decode_response_view->resources->kibana[0]->info->status != ''){
                                        $plankibanaSize = $json_decode_response_view->resources->kibana[0]->info->plan_info->current->plan->cluster_topology[0]->size->value;
                                        $plankibanaZone = $json_decode_response_view->resources->kibana[0]->info->plan_info->current->plan->cluster_topology[0]->zone_count;
                                        $kibanaAliasedUrl = $json_decode_response_view->resources->kibana[0]->info->metadata->aliased_url;
                                    }

                                    if($json_decode_response_view->resources->apm[0]->info->status != ''){
                                        $planApmSize = $json_decode_response_view->resources->apm[0]->info->plan_info->current->plan->cluster_topology[0]->size->value;
                                        $planApmZone = $json_decode_response_view->resources->kibana[0]->info->plan_info->current->plan->cluster_topology[0]->zone_count;
                                    }
                                    
                            }
                       
                            if($json_decode_response_view->healthy != ''){
                                $status = $json_decode_response_view->healthy;
                            }else{
                                $status = 0;
                            }

                            $deploymentsDataArray[$deploymentsId] =  array('id' => $deploymentsId, 
                                                                          'name' => $deploymentsIdAndName['name'],
                                                                          'status' => $status,
                                                                          'elasticSearchSize' => isset($currentPlanElasticSearchSize) ? $currentPlanElasticSearchSize : 'Deployment status is pending now',
                                                                          'elasticSearchZone' => isset($currentPlanElasticSearchZone) ? $currentPlanElasticSearchZone : 'Deployment status is pending now',
                                                                          'kibanaSize' => isset($plankibanaSize) ? $plankibanaSize : 'Deployment status is pending now',
                                                                          'kibanaZone' => isset($plankibanaZone) ? $plankibanaZone : 'Deployment status is pending now',
                                                                          'kibanaAliasedUrl' => isset($kibanaAliasedUrl) ? $kibanaAliasedUrl : 'Deployment status is pending now',
                                                                          'apmSize' => isset($planApmSize) ? $planApmSize : 'Deployment status is pending now',
                                                                          'apmZone' => isset($planApmZone) ? $planApmZone : 'Deployment status is pending now',                                                                        
                                                                        );                            
                    }   
                }
        }       
        return $deploymentsDataArray;
    }
}
// _________________________________________________________Deployment list api call function End__________________________________________________________

// _________________________________________________________Auth Function______________________________________________________________
if (!function_exists('settingData')) {
    function settingData() {
        $settingData = DB::table('settings')->first();    
        if(!empty($settingData) && $settingData != '' ){    
            return $settingData;
        } else {
            return false;
        }
    }
}

if (!function_exists('logInUserData')) {
  function logInUserData() {
      $userData['is_admin'] = isset($_COOKIE['is_admin']) ? $_COOKIE['is_admin'] : '';
      $userData['userName'] = isset($_COOKIE['userName']) ? $_COOKIE['userName'] : '';
      if(!empty($userData) && $userData != '' ){    
          return $userData;
      } else {
          return false;
      }
  }
}
if (!function_exists('userIsSuperAdmin')) {
    function userIsSuperAdmin() {
        $is_admin = isset($_COOKIE['is_admin']) ? $_COOKIE['is_admin'] : '';
        if($is_admin == 1){
            return true;
        }else{
            return false;
        }
    }
}
if (!function_exists('userLoggedIn')) {
    function userLoggedIn() {
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : '';    
        if(!empty($token) && $token != '' ){    
            return true;
        } else {
            header("Location:/admin/login");
            exit; 
        }
    }
}

if (!function_exists('getAccessToken')) {
    function getLoginAccessToken() {
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : '';    
        if(!empty($token) && $token != '' ){    
            return $token;
        } else {
            header("Location:/admin/login");
            exit; 
        }
    }
}
// _________________________________________________________Auth Function End______________________________________________________________


// _________________________________________________________API Function __________________________________________________________________

if (!function_exists('deploymentListApiCall')) {
     function deploymentListApiCall($API_PREFIX,$token){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => $API_PREFIX.'/api/deployment/list',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSLVERSION=> 0,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token.''
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);        
        return json_decode($response);

    }
}

if (!function_exists('deploymentViewApiCall')) {
    function deploymentViewApiCall($API_PREFIX,$token,$deploymentID){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $API_PREFIX.'/api/deployment/view',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token.'',
            'deploymentID: '.$deploymentID.''
          ),
        ));
        
        $response = curl_exec($curl);        
        curl_close($curl);
        return json_decode($response);
   }
}


// _________________________________________________________API Function End_____________________________________________________________________
