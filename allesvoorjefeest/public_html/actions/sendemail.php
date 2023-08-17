<?php
require_once '/home/u10448d24532/domains/eventsolutions.nu/core/system.init.php';

  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $onderwerp = filter_var($_POST["onderwerp"], FILTER_SANITIZE_STRING);
  $bericht = filter_var($_POST["bericht"], FILTER_SANITIZE_STRING);
  $voornaam = filter_var($_POST["voornaam"], FILTER_SANITIZE_STRING);
  $achternaam = filter_var($_POST["achternaam"], FILTER_SANITIZE_STRING);
  $telefoon = filter_var($_POST["telefoon"], FILTER_SANITIZE_STRING);
  $body = "Onderwerp: $onderwerp<br><br>Klantnaam: $voornaam $achternaam <br><br>Telefoon: $telefoon <br>E-mail: $email<br><br>Message: $bericht";
  
  $sendMail = sendMail::sendit("backoffice@eventsolutions.nu", "allesvoorjefeest.nl - ".$onderwerp, $body);
  $sendMailCopy = sendMail::sendit($email, "allesvoorjefeest.nl - ".$onderwerp, $body);
 
  if($sendMail) {
    print '<div class="card-panel light-green accent-4 white-text" style="font-size:15px;"><strong>Bedankt '.$voornaam.'</strong>, we gaan zo snel als mogelijk met je bericht aan de slag!</div><br><br>';
  } else {
    print '<div class="card-panel red darken-4 ">Er ging iets fout :-( Probeer het nogmaals of mail ons op backoffice@rentforevents.nl</div>';
    die($output);
  }

