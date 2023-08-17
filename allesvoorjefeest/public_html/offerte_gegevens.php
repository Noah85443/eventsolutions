<?php require_once 'core/system.init.php'; ?>
<!DOCTYPE html>
<html>
    <?php require_once AVJF_HEADERS; ?>
    <body>
        <?php require_once AVJF_NAVIGATION; ?>
        <main>
         <div class="container">
            <div class="section">
            <form action="/offerte-verzonden" method="post">
        	<?php
			$cart = $_SESSION['cart'];
			if (empty($cart)) { 
				print "Je offerte is nog leeg! Voeg artikelen toe om een eerste prijsopgave te zien.";
			}
			else { 
				?>
                    <div class="card-panel">
                    	<h6>Contactpersoon</h6>
                    	<div class="formField">
                        	<label for="voornaam">Voornaam<span class="red-text">*</span></label>
                            <input type="text" name="voornaam" placeholder="Voornaam" required />
                        </div>
                    	<div class="formField">
                        	<label for="tussenvoegsel">Tussenvoegsel</label>
                            <input type="text" name="tussenvoegsel" placeholder="tussenvoegsel" />
                    	</div>
                        <div class="formField">
                        	<label for="achternaam">Achternaam<span class="red-text">*</span></label>
                            <input type="text" name="achternaam" placeholder="Achternaam" required />
                    	</div>
                    </div>
                    <div class="card-panel">
                    	<h6>Contactgegevens</h6>
                        <div class="formField">	
                            <label for="telefoon">Telefoonnummer<span class="red-text">*</span></label>
                    		<input type="text" name="telefoon" placeholder="Telefoonnummer" required />
                       	</div>
                       	<div class="formField">
                            <label for="email">E-mailadres<span class="red-text">*</span></label>
                    		<input type="text" name="email" placeholder="E-mailadres" required />
                       	</div>
                    </div>
                    <div class="card-panel">
                    	<h6>Factuuradres</h6>
                    	<div class="formField">
                        	<label for="factuurStraat">Straat en nummer<span class="red-text">*</span></label>
                                <input type="text" name="factuurStraat" placeholder="Straat" required /><input type="text" name="factuurNummer" placeholder="Nr" /></div>
                    	<div class="formField">
                        <label for="factuurPostcode">Postcode<span class="red-text">*</span></label>
                        <input type="text" name="factuurPostcode" placeholder="Postcode" required /></div>
                    	<div class="formField">
                        	<label for="factuurPlaats">Plaats<span class="red-text">*</span></label>
                            <input type="text" name="factuurPlaats" placeholder="Plaats" required />
                    </div>
                        </div>
                    <div class="card-panel">
                    	<h6>Levering</h6>
                    	<div class="formField">
                        	<label for="levering">Levering<span class="red-text">*</span></label>
                            <select name="levering" required> 
                    			<option id="afhalen" value="afhalen">Zelf halen en brengen</option>
                        		<option id="bezorgen" value="bezorgen">Bezorgen en ophalen</option>
                    		</select>
                        </div>
                    	<div class="formField">
                        	<label for="leveringStraat">Straat en nummer</label>
                            <input type="text" name="leveringStraat" placeholder="Straat" /><input type="text" name="leveringNummer" placeholder="Nr" />
                    	</div>
                        <div class="formField">
                        	<label for="leveringPostcode">Postcode</label>
                            <input type="text" name="leveringPostcode" placeholder="Postcode" />
                    	</div>
                        <div class="formField">
                        	<label for="leveringPlaats">Plaats</label>
                            <input type="text" name="leveringPlaats" placeholder="Plaats" />
                       	</div>
                    </div>
                    <div class="card-panel">
                    	<h6>Datums</h6>
                    	<div class="formField">
                        	<label for="leveringBezorgen">Bezorg/afhaaldatum<span class="red-text">*</span></label>
                            <input type="date" name="leveringBezorgen" required />
                    	</div>
                        <div class="formField">
                        	<label for="gebruikBegin">Begin huurperiode<span class="red-text">*</span></label>
                            <input type="date" name="gebruikBegin" required />
                    	</div>
                        <div class="formField">
                        	<label for="gebruikEinde">Einde huurperiode<span class="red-text">*</span></label>
                            <input type="date" name="gebruikEinde" required />
                    	</div>
                        <div class="formField">
                        	<label for="leveringOphalen">Retour/ophaaldatum<span class="red-text">*</span></label>
                            <input type="date" name="leveringOphalen" required />
						</div>
                </div>
        <?php } ?>
        <button type="submit" name="sendQuote" class="btn green"><i class="material-icons right">send</i>Verstuur aanvraag</button>
    </form>
            </div>
        </div>
    </main>
<?php 
            require_once AVJF_FOOTER; 
            require_once AVJF_SCRIPTS;
        ?>     
    </body>
</html>