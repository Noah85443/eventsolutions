<?php

$name = $_GET['name'];
$mail = $_GET['mail'];
$message = $_GET['message'];

$to = "backoffice@eventsolutions.nu";
$subject = "[CONTACTFORMULIER] Nieuwe informatie-aanvraag";
$txt = "Afzender: ".$name." (".$mail.")\n\nBericht: ".$message;
$headers = "From: backoffice@eventsolutions.nu";

mail($to,$subject,$txt,$headers);

echo "Bericht verzonden!";
?>