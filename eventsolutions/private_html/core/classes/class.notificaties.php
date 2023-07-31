<?php
    class Notificaties {	
        
        public static function verstuurFactuur($factuurNr) {      
            $factuurData = facturatie::opFactuurNummer($factuurNr);
            $relatie = relaties::perRelatie($factuurData->relatie);
            $projecten = json_decode($factuurData->projecten, true);
            $projectnamen = null;
            for($x=0;$x<count($projecten);$x++) {
            $projectnamen .= "- ". projecten::perProject($projecten[$x])->projectNaam."<br>";
            }
            $bedrag = "&euro; ".$factuurData->totaal;
            $factuurDatum = convert::datumKort($factuurData->datum);
            $vervalDatum = convert::datumKort($factuurData->vervaldatum);
            $bijlage = SERVER.HOST.'/public_html/'.$factuurData->pdfLocatie;
            
            $subject = "Factuur {$factuurNr}";
            $message = "
                Beste {$relatie->factuur_tav},<br><br>
                Hartelijk dank voor de prettige samenwerking!<br><br>
                Hierbij sturen we je de factuur toe voor de volgende projecten:<br>
                {$projectnamen}
                <br>
                De factuur in het kort:<br>
                Factuurnummer: {$factuurData->nummer}<br>
                Factuurdatum: {$factuurDatum}<br>
                Vervaldatum: {$vervalDatum}<br>
                Totaalbedrag: ".$bedrag."<br><br>
                Er zijn diverse mogelijkheden voor het betalen van de factuur:<br>
                <a href=\"https://payments.".HOST."/betaling/{$factuurData->betaalcode}\">Klik hier om met iDeal, Creditcard, Paypal of Apple Pay te betalen</a><br><br>
                Het is uiteraard ook mogelijk het bedrag handmatig over te boeken.<br>Alle gegevens hiervoor zijn vermeld op de factuur.
                <br><br>
                Heb je een EventSolutions-klantaccount?<br>
                Dan is de factuur vanaf nu ook daar terug te vinden onder 'Facturen'.<br><br>
                Heb je nog vragen over deze e-mail, het klantaccount of de factuur?<br>
                Neem dan contact met ons op, dat kan door simpelweg te antwoorden op dit bericht.
                <br><br>
                Met vriendelijke groet,<br>
                EventSolutions
            ";
                
            $sendMail = sendMail::sendit($relatie->factuur_email, $subject, $message, $bijlage);
            return $sendMail;
	}
        
        public static function verstuurUrenValidatie($projectId) {      
            $projectInfo = projecten::perProject($projectId);
            $email = relaties::perRelatie($projectInfo->relatie)->email;
            $koppelcode = relaties::perRelatie($projectInfo->relatie)->koppelcode;
            $subject = "Urenoverzicht ".$projectInfo->projectNaam;
            $message = ""
                . "Beste relatie,<br /><br />"
                . "Het urenoverzicht van ".$projectInfo->projectNaam." staat vanaf dit moment klaar in onze online omgeving.<br /><br />"
                . "We vragen je vriendelijk het aangeboden urenoverzicht en kostenoverzicht te controleren en digitaal goed te keuren.<br /><br />"
                . "<a href=\"https://relaties.eventsolutions.nu/\">Ga naar de online omgeving ></a><br /><br /> "    
                . "<i>Ben je het er niet helemaal mee eens?</i><br/>"
                . "Neem dan contact op met de projectleider van het project. Dan komen we samen tot een oplossing.<br /><br />"
                . "Met gastvrije groet,<br />
                    Planning & Logistiek<br />
					EventSolutions";
        $sendMail = sendMail::sendit($email, $subject, $message, $attach = '');
        return $sendMail;
	}
}