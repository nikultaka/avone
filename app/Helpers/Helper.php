<?php

if (!function_exists('curlCall')) {
    function curlCall($method,$path,$postdata='')
    {
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
              CURLOPT_POSTFIELDS =>$postdata,
              CURLOPT_HTTPHEADER => array(
                'Authorization: ApiKey '.env("EC_API_KEY"),
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}