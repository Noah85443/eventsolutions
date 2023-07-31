<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
    
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $data = verhuurArtikelen::artikel($id);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">category</span>
       <span class="text-secondary">&nbsp; > &nbsp; Artikel &nbsp; > &nbsp;</span>
       <span><?php print $data->artikelnaam; ?></span>
   </h4> 
       <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/verhuur/artikel/<?php print $data->id; ?>/bewerken" class="btn btn-outline-warning">
            <span class="material-icons-outlined float-start pe-2">edit</span>
            Bewerken
          </a>
        </div>
</div>

<div class="container">
    <div class="row">
        <div class="col p-3">
            <img src="<?php print STYLE_IMAGES.'/rentalProducten/'.$data->afbeelding; ?>" alt="Productafbeelding" class="img-fluid img-thumbnail" />
        </div>
        <div class="col p-3">
            Categorie: <?php print $data->artikelgroep->naam; ?><br />
            Artikelnr: <?php print $data->artikelnr; ?><br /><br />
                <?php 
                    if($data->samengesteld) {
                        print "<i class=\"material-icons\" style=\"vertical-align: -6px; padding-right: 10px;\">dns</i>Samengesteld artikel";
                    }
                ?>
        </div>
        <div class="col p-3">
            <strong>Artikelomschrijving</strong><br />
                <?php print $data->beschrijving; ?>
                <br /><br /><hr /><br />
                Kenmerken:<br />
                <?php print $data->kenmerken; ?>
        </div>
    </div>
    <div class="row">
        <div class="col p-3">
            <table class="table">
                    <tr>
                        <td>Type:</td>
                        <td><?php print $data->artikelsoort; ?></td>
                    </tr>
                    <tr>
                        <td>Voorraad:</td>
                        <td><?php print $data->aantal; ?></td>
                    </tr>
                    <tr>
                        <td>Inhuur:</td>
                        <td><?php print $data->inhuurartikel; ?></td>
                    </tr>
                    <tr>
                        <td>Stukprijs (excl.):</td>
                        <td><?php print $data->prijs; ?></td>
                    </tr>
                    <tr>
                        <td>BTW Tarief</td>
                        <td><?php print $data->btwTarief; ?> %</td>
                    </tr>
                    <tr>
                        <td>Mancoprijs</td>
                        <td><?php print $data->mancoprijs; ?></td>
                    </tr>
                </table>
        </div>
        <div class="col p-3">
            Samenstelling artikel<br /><br />
                <?php 
                    if($data->samengesteld == 1) {
                        $onderdelen = json_decode($data->onderdelen,true);
                        print "Type: Samenstelling diverse artikelen";
                        print "<table>";
                            foreach($onderdelen as $artikel => $aantal) {
                                $artikelinfo = verhuurArtikelen::artikel($artikel);
                                print "
                                    <tr>
                                        <td>{$aantal}x</td>
                                        <td>{$artikelinfo->artikelnaam}</td>
                                        <td><a href=\"/verhuur/artikel/{$artikelinfo->id}\"><i class=\"material-icons blue-text text-lighten-3 right\">visibility</i></a></td>
                                    </tr>";
                            }
                        print "</table>";
                    }
                    elseif($data->samengesteld == 2) {
                        print "Type: Zelfde artikel, besteleenheid";
                        print "<table>
                                    <tr>
                                        <td>{$data->stuksPerEenheid}x</td>
                                        <td>{$data->artikelnaam}</td>
                                    </tr>
                                </table>";
                    }
                    else {
                        print "Dit artikel is geen samenstelling";
                    }
                ?>
        </div>
        <div class="col p-3">
            Emballage voor dit artikel<br/><br/>
                <?php
                if(!empty($data->emballage)) {
                        $emballage = json_decode($data->emballage,true);
                        print "<table>";
                            foreach($emballage as $artikel => $aantal) {
                                $artikelinfo = verhuurEmballage::artikel($artikel);
                                print "
                                    <tr>
                                        <td>{$aantal}x</td>
                                        <td>{$artikelinfo->naam}</td>
                                        <td><a href=\"/verhuur/emballage/{$artikelinfo->artikelNr}\"><i class=\"material-icons blue-text text-lighten-3 right\">visibility</i></a></td>
                                    </tr>";
                            }
                        print "</table>";
                    }
                    else {
                        print "Er is geen emballage gekoppeld aan dit artikel.";
                    }
                ?>
        </div>
    </div>
</div>

<?php
 require_once FOOTER;