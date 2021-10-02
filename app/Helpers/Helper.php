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
