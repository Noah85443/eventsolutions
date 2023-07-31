<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
    
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $data = verhuurArtikelen::artikel($id);
    
    if (filter_has_var(INPUT_POST, "updateArtikel")){
        $dataset = filter_input_array(INPUT_POST);
        unset($dataset['updateArtikel']);
 
        try {
            $action = verhuurArtikelen::updateArtikel($dataset,$dataset['id']);
        }
        catch (Exception $e) {
            print "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
        }
 
        if($action == 1) {
            print "<div class=\"notification success\">Artikel succesvol bewerkt</div>";
        }
    }
    
?>
 
 <form method="post">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">category</span>
       <span class="text-secondary">&nbsp; > &nbsp; Artikel &nbsp; > &nbsp;</span>
       <span><input type="text" value="<?php print $data->artikelnaam; ?>" name="artikelnaam"/></span>
   </h4>
     <div class="btn-toolbar mb-2 mb-md-0">
          <button type="submit" name="updateArtikel" class="btn btn-outline-success">Opslaan</button>
        </div>
</div>

<div class="container">
   
    <div class="row">
        <div class="col p-3">
            <img src="<?php print STYLE_IMAGES.'/rentalProducten/'.$data->afbeelding; ?>" alt="Productafbeelding" class="img-fluid img-thumbnail" />
        </div>
        <div class="col p-3">
            Artikelgroep:<br />
                <select name="artikelgroep" id="artikelgroep">
                    <option value="0" disabled selected>Geen artikelgroep geselecteerd</option>
                    <?php 
                        $artikelgroepen = verhuurArtikelgroepen::alleArtikelgroepen();
                        for($x=0;$x<count($artikelgroepen);$x++) {
                            print "<option value=\"{$artikelgroepen[$x]->id}\""; if($data->artikelgroep->id == $artikelgroepen[$x]->id) {print "selected";} print ">{$artikelgroepen[$x]->naam}</option>";
                        }
                    ?>
                </select><br /><br />
                Artikel ID: <br /><input type="text" value="<?php print $data->id; ?>" name="id" readonly />
                <br /><br />
                Artikelnr: <br /><input type="text" value="<?php print $data->artikelnr; ?>" name="artikelnr"/><br /><br />
                <?php 
                    if($data->samengesteld) {
                        print "<i class=\"material-icons\" style=\"vertical-align: -6px; padding-right: 10px;\">dns</i>Samengesteld artikel";
                    }
                ?>
        </div>
        <div class="col p-3">
         <strong>Artikelomschrijving</strong><br />
                <textarea id="beschrijving" name="beschrijving" rows="6" cols="50">
                    <?php print $data->beschrijving; ?>
                </textarea>
                <br /><br /><hr /><br />
                Kenmerken:<br />
                <textarea id="kenmerken" name="kenmerken" rows="6" cols="50">
                    <?php print $data->kenmerken; ?>
                </textarea>
        </div>
    </div>
    <div class="row">
        <div class="col p-3">
            <table>
                    <tr>
                        <td>Type:</td>
                        <td><select name="artikelsoort" id="artikelsoort">
                                <?php 
                                    print "<option value=\"0\""; if($data->artikelsoort == "verhuur") {print "selected";} print ">Verhuur</option>";
                                    print "<option value=\"0\""; if($data->artikelsoort == "verkoop") {print "selected";} print ">Verkoop</option>";
                                    print "<option value=\"0\""; if($data->artikelsoort == "verbruik") {print "selected";} print ">Verbruik</option>";
                                    print "<option value=\"0\""; if($data->artikelsoort == "custom") {print "selected";} print ">Speciaal vervaardigd</option>";
                                ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Voorraad:</td>
                        <td><input type="text" value="<?php print $data->aantal; ?>" name="aantal" /></td>
                    </tr>
                    <tr>
                        <td>Inhuur:</td>
                        <td>
                            <select name="inhuurartikel" id="inhuurartikel">
                                <?php 
                                    print "<option value=\"0\""; if($data->inhuurartikel == 0) {print "selected";} print ">Eigen voorraad</option>";
                                    print "<option value=\"0\""; if($data->inhuurartikel == 1) {print "selected";} print ">Inhuurartikel</option>";
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Stukprijs (ex BTW):</td>
                        <td><input type="text" value="<?php print $data->prijs; ?>" name="prijs" /></td>
                    </tr>
                    <tr>
                        <td>BTW Tarief</td>
                        <td>
                            <select name="btwTarief" id="btwTarief">
                                <option value="0" disabled selected>Geen BTW percentage</option>
                                <?php 
                                    print "<option value=\"9\""; if($data->btwTarief == 9) {print "selected";} print ">9% BTW</option>";
                                    print "<option value=\"21\""; if($data->btwTarief == 21) {print "selected";} print ">21% BTW</option>";
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Mancoprijs</td>
                        <td><input type="text" value="<?php print $data->mancoprijs; ?>" name="mancoprijs" /></td>
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
     </form>
<?php
 require_once FOOTER;