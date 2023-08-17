<?php
session_start();

define('AVJF_HEADERS','core/header.php');
define('AVJF_NAVIGATION','core/navigation.php');
define('AVJF_FOOTER','core/footer.php');
define('AVJF_SCRIPTS','core/includes_js.php');

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
                $obj = array("message" => "Error recieving data", "HTTPcode" => $httpcode, "result" => json_decode($result));
            }
        }
        else {
            $obj = array("message" => "No scrope provided.");
        }
        return $obj; 
        }
}

class convert {
    public static function prijs($bruto,$btw) {
        $netto = $bruto * (1 + ($btw/100));
        $amount = new \NumberFormatter( 'nl_NL', \NumberFormatter::CURRENCY );
        return $amount->format($netto);
    }
    
    public static function toEuro($value) {
        $amount = new \NumberFormatter( 'nl_NL', \NumberFormatter::CURRENCY );
        return $amount->format($value);
    }
}