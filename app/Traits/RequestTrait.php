<?php 

namespace App\Traits;

trait RequestTrait {
    
    private function apiRequest($method, $parameters = [])
    {
        $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/' . $method;
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($parameters));
        
        $response = curl_exec($handle);

        if($response === false) {
            curl_close($handle);
            return false;
        }

        $response = json_decode($handle, true);
        curl_close($handle);
        
        if($response['ok'] == false) {
            return false;
        }
        
        $response = $response['result'];
        return $response;
    }

}

?>