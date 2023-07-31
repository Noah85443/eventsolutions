<?php
function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

function getBearerToken() {
    $headers = getAuthorizationHeader();
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function checkBearerToken() {
    $token = getBearerToken();
    if(!empty($token)) {
        if ($token != "489taosdfh4taskdhfasDfajkfh4efasd") {
            http_response_code(404);
            echo json_encode(
                array("message" => "API token invalid")
            );
            exit();
        }
    }
    else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No API token supplied")
        );
        exit();
    }
}
?>