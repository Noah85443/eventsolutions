<?php
$headers = array(
    'Content-Type: application/json',
    sprintf('Authorization: Bearer %s', '489taosdfh4taskdhfasDfajkfh4efasd')
);

$ch = curl_init("https://api.eventsolutions.nu/verhuur/artikelgroepen/artikelen/bestek-trendy/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$obj = json_decode($result);

print $httpcode;
print_r($obj); 