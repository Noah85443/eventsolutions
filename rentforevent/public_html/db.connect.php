<?php
$servername = "localhost";
$username = "u10448d24532_rfeadmin";
$password = "CNvSNjUWa8";

try {
    $conn = new PDO("mysql:host=$servername;dbname=u10448d24532_RFE", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed. Please try again later.";
}
?>