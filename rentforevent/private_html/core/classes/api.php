<?php
class API {
    public static function Call($scope, $value = null, $data = null) {
        if(!empty($scope)) {
            $headers = array(
                'Content-Type: application/json',
                sprintf('Authorization: Bearer %s', '489taosdfh4taskdhfasDfajkfh4efasd')
            );
        
            $url = "https://api.eventsolutions.nu/verhuur/".$scope."/".$value;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            if(!empty($data)) {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }

            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
            if($httpcode == 200 OR $httpcode == 404) {
                $obj = json_decode($result);
            }
            else {
                $obj = array("message" => "Error recieving data", "HTTPcode" => $httpcode);
            }
        }
        else {
            $obj = array("message" => "No scope provided.");
        }
        return $obj; 
        }
}
?>