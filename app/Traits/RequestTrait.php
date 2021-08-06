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
        
        curl_close($handle);
        $response = json_decode($response, true);
        
        return $response;
    }

    private function sendDocument($parameters = [])
    {
        $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendDocument';
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        // Create File
        $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $parameters['document']);
        $cFile = new CURLFile($parameters['document'], $finfo);
        $parameters['document'] = $cFile;
        
        curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($parameters));
        
        $response = curl_exec($handle);

        if($response === false) {
            curl_close($handle);
            return false;
        }
        
        curl_close($handle);
        $response = json_decode($response, true);
        
        return $response;
    }

}

?>