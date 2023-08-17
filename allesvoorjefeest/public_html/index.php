<?php require_once 'core/system.init.php'; ?>
<!DOCTYPE html>
<html>
    <?php require_once AVJF_HEADERS; ?>
    <body>
        <?php require_once AVJF_NAVIGATION; ?>
        <main>
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <h1 class="header center orange-text">Je feest begint hier</h1>
                <div class="row center">
                    <h5 class="header col s12 light">Alles voor een onvergetelijk feest staat bij ons voor je klaar</h5>
                </div>
                <div class="row center">
                    <a href="/verhuur" id="download-button" class="btn-large waves-effect waves-light cyan">Bekijk assortiment</a>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center light-blue-text"><i class="material-icons medium cyan-text">shopping_cart</i></h2>
                            <h5 class="center">Losse verhuur</h5>
                            <p class="light">
                                Al een goed begin gemaakt? Wij helpen je graag om je feest helemaal af te maken!<br>
                                Van heater tot tafeldecoratie en van lichtletter tot wijnglas:<br>Het staat voor je klaar.
                            </p>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center light-blue-text"><i class="material-icons medium cyan-text">local_shipping</i></h2>
                            <h5 class="center">Transport</h5>
                            <p class="light">
                                Zelf ophalen en terugbrengen? Geen grote auto en liever laten bezorgen en ophalen?<br><br>
                                Totaal geen probleem natuurlijk! Bezorgen is al mogelijk vanaf € 24,95!
                                
                            </p>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="icon-block">
                            <h2 class="center light-blue-text"><i class="material-icons medium cyan-text">insert_emoticon</i></h2>
                            <h5 class="center">Volledig ontzorgd</h5>
                            <p class="light">
                                Onze ervaren evenementenbouwers zorgen er met liefde voor dat je volledige feest spic-en-span voor je klaarstaat.<br>
                                Uiteraard komen we het ook weer afbreken en laten we alles netjes achter.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
        <?php 
            require_once AVJF_FOOTER; 
            require_once AVJF_SCRIPTS;
        ?>        
    </body>
</html>