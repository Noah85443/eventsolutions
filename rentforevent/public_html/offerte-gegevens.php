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
            }
            else { 
            ?>
            <form action="/offerte-verzonden" method="post" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Bedrijfsgegevens</h5>
                            <div class="row my-4">
                                <div class="col-12">
                                    <label for="bedrijf" class="form-label small">Bedrijfsnaam*</label>
                                    <input type="text" class="form-control" name="bedrijf" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-6">
                                    <label for="kvk" class="form-label small">KvK-nummer*</label>
                                    <input type="text" class="form-control" name="kvk" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="btw" class="form-label small">BTW-nummer</label>
                                    <input type="text" class="form-control" name="btw">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Contactpersoon</h5>
                            <div class="row my-4">
                                <div class="col-md-4">
                                    <label for="voornaam" class="form-label small">Voornaam*</label>
                                    <input type="text" class="form-control" name="voornaam" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="tussenvoegsel" class="form-label small">Tussenvoegsel</label>
                                    <input type="text" class="form-control" name="tussenvoegsel">
                                </div>
                                <div class="col-md-5">
                                    <label for="achternaam" class="form-label small">Achternaam*</label>
                                    <input type="text" class="form-control" name="achternaam" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-6">
                                    <label for="telefoon" class="form-label small">Telefoonnummer</label>
                                    <input type="text" class="form-control" name="telefoon">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label small">E-mailadres*</label>
                                    <input type="text" class="form-control" name="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <h5>Factuuradres</h5>
                            <div class="row my-4">
                                <div class="col-md-9">
                                    <label for="factuurStraat" class="form-label small">Straatnaam*</label>
                                    <input type="text" class="form-control" name="factuurStraat" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="factuurNummer" class="form-label small">Nr.*</label>
                                    <input type="text" class="form-control" name="factuurNummer" required>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-4">
                                    <label for="factuurPostcode" class="form-label small">Postcode*</label>
                                    <input type="text" class="form-control" name="factuurPostcode" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="factuurPlaats" class="form-label small">Vestigingsplaats*</label>
                                    <input type="text" class="form-control" name="factuurPlaats" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Levering</h5>
                            <div class="row my-4">
                                <div class="col-12 mb-4">
                                    <label for="levering" class="mb-1 small">Leveringsconditie*</label>
                                    <select name="levering" class="form-select" required> 
                    			<option id="afhalen" value="afhalen">Zelf halen en brengen</option>
                        		<option id="bezorgen" value="bezorgen">Bezorgen en ophalen</option>
                                    </select>
                                </div>
                                <div class="col-md-9">
                                    <label for="leveringStraat" class="form-label small">Straatnaam</label>
                                    <input type="text" class="form-control" name="leveringStraat">
                                </div>
                                <div class="col-md-3">
                                    <label for="leveringNummer" class="form-label small">Nr.</label>
                                    <input type="text" class="form-control" name="leveringNummer">
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-4">
                                    <label for="leveringPostcode" class="form-label small">Postcode</label>
                                    <input type="text" class="form-control" name="leveringPostcode">
                                </div>
                                <div class="col-md-8">
                                    <label for="leveringPlaats" class="form-label small">Plaats</label>
                                    <input type="text" class="form-control" name="leveringPlaats">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <h5>Wanneer wil je bij ons huren?</h5>
                        <div class="col-md-3">
                            <label for="leveringBezorgen" class="form-label small">Voorkeur Bezorg/afhaaldatum*</label>
                            <input type="date"  class="form-control" name="leveringBezorgen" required >
                        </div>
                        <div class="col-md-3">
                            <label for="gebruikBegin" class="form-label small">Begin huurperiode*</label>
                            <input type="date" name="gebruikBegin" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="gebruikEinde" class="form-label small">Einde huurperiode*</label>
                            <input type="date" name="gebruikEinde" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="leveringOphalen" class="form-label small">Voorkeur Retour/Ophaaldatum*</label>
                            <input type="date" name="leveringOphalen" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 g-4">
                            <button type="submit" name="sendQuote" class="btn btn-success">
                                <i class="material-symbols-outlined" style="float:left;padding-right:10px;">keyboard_double_arrow_right</i>Offerte aanvragen
                            </button>
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
        <?php require_once footer; ?>
        <?php require_once scripts; ?>
        <script src="/core/scripts/form-validation.js"></script>
    </body>
</html>
