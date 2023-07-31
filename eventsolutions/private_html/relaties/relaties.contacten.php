<?php
    $accessLevel = array("relatie");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $dataset = relaties::cpPerRelatie($account->getUserData()->linked_customer);
    
    if (isset($_POST['sendInvite'])){
        $email = filter_input(INPUT_POST, "email", FILTER_DEFAULT);
        $name = filter_input(INPUT_POST, "name", FILTER_DEFAULT);
        $companyId = $account->getUserData()->linked_customer;
        $user = $account->getUserData()->account_realname;
        $koppelcode = relaties::perRelatie($companyId)->koppelcode;
        
        $subject = "Uitnodiging voor toegang bedrijfsgegevens";
        $message = "Beste {$name},<br /><br />{$user} heeft je uitgenodigd om toegang te krijgen tot de gegevens van jullie bedrijf bij EventSolutions.<br /><br />"
        . "In deze online omgeving kun je onder andere de komende en afgeronde projecten bekijken, de projectplanning inzien en het factuuroverzicht bekijken.<br /><br />"
        . "<strong>Hoe nu verder?</strong><br />"
                . "<strong>Stap 1:</strong> Om toegang te krijgen vragen we je om een persoonlijk account aan te maken.<br />Dat kan via de volgende link:<br /><br />"
                . "<a href=\"https://accounts.eventsolutions.nu/onboarding/nieuw-account\">Klik hier om een account aan te maken.</a><br /><br />"
                . "Na het invullen van de gegevens krijg je op het opgegeven e-mailadres een tijdelijk wachtwoord toegestuurd. Hiermee kun je inloggen en verder met stap 2.<br /><br />"
                . "<strong>Stap 2:</strong> Nadat je account is aangemaakt en je hebt ingelogd, kun je jouw account koppelen aan het bedrijf waardoor je bent uitgenodigd. Klik hiervoor op de blauwe button 'Zakelijk klantaccount toevoegen' op het startscherm van je account.<br /><br />"
                . "Voer hier vervolgens de volgende koppelcode in: <strong>{$koppelcode}</strong><br /><br />"
                . "Je bent daarna succesvol gekoppeld aan de gegevens van je bedrijf. Via <a href=\"https://relaties.eventsolutions.nu\">https://relaties.eventsolutions.nu</a> kom je altijd direct in de omgeving van je bedrijf.<br /><br />"
                . "Heb je vragen over het aanmaken van je account of waarom je deze mail hebt ontvangen? Neem dan gerust contact met ons op, we helpen je graag!<br />"
                        . "We zijn te bereiken via backoffice@eventsolutions.nu of 026 - 202 29 43<br /><br />Met gastvrije groet,<br />Het team van EventSolutions";
        
        $mail = sendMail::sendit($email, $subject, $message);
        
        print "
            <div class=\"alert alert-success\">
                {$mail}
            </div>
        ";
    }
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">people</span>
       <span class="text-secondary">Relaties &nbsp; > &nbsp; </span>
       <span>Contactpersonen</span>
   </h4> 
</div>
<div class="row">
    <div class="col-7 pe-5">
        <div class="row">
        <?php 
            for($x=0; $x < count($dataset); $x++) { 
                print '
                    <div class="col-12 mb-4 border border-dark-subtle rounded-3 p-3">
                        <p class="fw-semibold mb-1">'.$dataset[$x]->account_realname.'</p>
                        <p class="mb-1 fst-italic">'.$dataset[$x]->account_name.'</p>
                    </div>
                ';    
            }
        ?>
        </div>
    </div>
    <div class="col-5 bg-dark-subtle rounded-3 p-4">
        <h6 class="pb-3">Collega uitnodigen</h6>
        <form method="post">
            <input type="text" class="form-control mb-2" name="name" placeholder="Naam collega" />
            <input type="email" class="form-control mb-3" name="email" placeholder="E-mailadres" />
        <p>Vul in het veld hierboven het e-mailadres in van de collega.<br /> 
        welke je wilt uitnodigen om toegang te krijgen tot de gegevens van dit bedrijf.<br /><br />
        Je collega ontvangt dan een uitnodiging om een account aan te maken en de koppelcode voor dit bedrijf.</p>
        <button type="submit" name="sendInvite" class="btn btn-dark float-end mt-3">Uitnodigen</button>
        </form>
        
    </div>
</div>
<?php
 require_once FOOTER;