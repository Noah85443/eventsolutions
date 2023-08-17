<?php
require_once 'core/system.init.php';
?>
<!doctype html>
<html lang="en">
<?php require_once header; ?>

<body>
    <?php require_once navigation; ?>
    <div class="container">
        <?php
        $cart = $_SESSION['cart'];
        if (empty($cart)) {
            print "Je offerte is nog leeg! Voeg artikelen toe om een eerste prijsopgave te zien.";
        } else {
            print "<h3>Bedankt voor je offerte-aanvraag.</h3>We zullen je zo snel mogelijk een passend voorstel doen.<br><br>"
                . "Een kopie van je aanvraag ontvang je binnen enkele minuten op het ingevoerde e-mailadres.";
        }

        foreach ($cart as $productId => $count) {
            $artikel = API::Call("artikel", $productId);

            $artikelen[] = array(
                "artikel_id" => $productId,
                "aantal" => $count,
                "naam" => $artikel->artikelnaam,
                "prijs" => $artikel->prijs,
                "korting" => 0,
                "factor" => 1,
                "btw" => $artikel->btwTarief,
                "type" => $artikel->artikelsoort,
                "manco_prijs" => $artikel->mancoprijs,
                "manco_stuks" => 0
            );
        }

        $adres = array(
            "straat" => $_POST['factuurStraat'],
            "huisnummer" => $_POST['factuurNummer'],
            "postcode" => $_POST['factuurPostcode'],
            "plaats" => $_POST['factuurPlaats'],
            "land" => "NL"
        );
        $contactgegevens = array(
            "voornaam" => $_POST['voornaam'],
            "tussenvoegsel" => $_POST['tussenvoegsel'],
            "achternaam" => $_POST['achternaam'],
            "adres" => $adres,
            "email" => $_POST['email'],
            "telefoonnummer" => $_POST['telefoon']
        );

        $bezorgadres = array(
            "straat" => $_POST['leveringStraat'],
            "huisnummer" => $_POST['leveringNummer'],
            "postcode" => $_POST['leveringPostcode'],
            "plaats" => $_POST['leveringPlaats'],
            "land" => "NL"
        );

        $factuuradres = array(
            "straat" => $_POST['factuurStraat'],
            "huisnummer" => $_POST['factuurNummer'],
            "postcode" => $_POST['factuurPostcode'],
            "plaats" => $_POST['factuurPlaats'],
            "land" => "NL"
        );

        if (!empty($artikelen)) {
            try {
                $dataset = array(
                    "bron" => "rentforevents",
                    "type" => "verhuur",
                    "status" => "aanvraag_website",
                    "contactgegevens" => $contactgegevens,
                    "artikelen" => $artikelen,
                    "huurperiode_start" => $_POST['gebruikBegin'],
                    "huurperiode_eind" => $_POST['gebruikEinde'],
                    "levering" => $_POST['levering'],
                    "aanvoerdatum" => $_POST['leveringBezorgen'],
                    "retourdatum" => $_POST['leveringOphalen'],
                    "bezorgadres" => $bezorgadres,
                    "factuur_tav" => $_POST['voornaam'],
                    "factuur_email" => $_POST['email'],
                    "factuur_adres" => $factuuradres
                );

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        $api = API::Call("project/nieuw", null, $dataset);
        unset($_SESSION['cart']);
        $isSend = 1;
        ?>
    </div>
    <?php require_once footer; ?>
    <?php require_once scripts; ?>
</body>

</html>