<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
?>

<?php
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$factuurData = facturatie::opFactuurNummer($id);

$relatie = relaties::perRelatie($factuurData->relatie);
$projecten = json_decode($factuurData->projecten);

foreach($projecten as $project) {
    $factuurdata[$project] = facturatie::dataPerProject($project);
}
$dataset = json_decode(json_encode($factuurdata), FALSE);

    $content = "
    <div class=\"row top-padding\">
        <div class=\"col ps-4 w-50\">
            <strong>{$relatie->klant_naam}</strong> <br />
            t.a.v. {$relatie->factuur_tav}<br />
			{$relatie->factuur_email}
			<br /><br />
            {$relatie->straat}<br />
            {$relatie->postcode} {$relatie->plaats}, {$relatie->land}
            <br /><br />
            KvK {$relatie->zakelijk_kvk}<br />
            BTW-id {$relatie->zakelijk_btw}
        </div>
    </div>
	<div class=\"row pb-3 top-padding-s\">
	<div class=\"col w-50\">
            <h6 class=\"fw-semibold text-success pb-2\"><strong>Factuur {$id}</strong></h6>
        </div>
		<div class=\"col w-50 float-end factuurdata\">
            Factuurdatum: ".convert::datumKort($factuurData->datum)."<br />
            Vervaldatum: ".convert::datumKort($factuurData->vervaldatum)."
        </div>
	</div>
	<div class=\"container py-4\">
            <div class=\"row pt-2\">
                <div class=\"col\">
                    <table class=\"table\">
						<tr>
                            <th colspan=\"2\">Omschrijving</th>
                            <th>Stukprijs</th>
							<th>Factor</th>
                            <th>Totaal</th>
                            <th>BTW</th>
                        </tr>
						";
    foreach($projecten as $project) {
        $projectInfo = projecten::perProject($project); 
        $content .= '
						<tr>
							<td colspan="4" style="background:#CCC">
								<span style="padding-left: 10px">'.$projectInfo->projectNaam.'</span><br />
								<i>'.$projectInfo->klantKenmerk.'</i>
							</td>
							<td colspan="2" style="background:#CCC">
								<div style="display:block;padding-right:15px;text-align:right;align:right">'.convert::datumKort($projectInfo->datumBegin).' - '.convert::datumKort($projectInfo->datumEind).'</div>
							</td>
						</tr>
                        
                    ';
                        $projectBruto = 0; $projectBtw = 0;
                        foreach($dataset->$project as $product => $info) {
                            $projectBruto += $info->totaalBruto;
                            $projectBtw += $info->totaalBtw;

                            $content .= "<tr>"
                            . "<td>{$info->aantal} x</td>"
                            . "<td>{$info->productNaam}</td>"
                            . "<td>".convert::toEuro($info->regelBruto)."</td>"
							. "<td>1,00</td>"
                            . "<td>".convert::toEuro($info->totaalBruto)."</td>"
                            . "<td>{$info->btwPercentage}%</td>"
                            . "</tr>";
                            
                            $subTotaal[] = array(
                                "bruto" => $info->totaalBruto, 
                                "netto" => $info->totaalNetto, 
                                "btwBedrag" => $info->totaalBtw, 
                                "btwPercentage" => $info->btwPercentage
                            );
                            
                            $exportToMb[] = array(
                                'id' => $info->productExtId,
                                'description' => $info->productNaam,
                                'price' => $info->regelBruto,
                                'amount' => $info->aantal,
                                'tax_rate_id' => $info->mbBtwId,
                                'ledger_account_id' => $info->productGbVerkoop
                            );
                        }
                        $projectNetto = $projectBruto + $projectBtw;
                        
                        $content .= ' 
                            <tr>
                                <td colspan="3"></td>
								<td><strong>Subtotaal</strong></td>
                                <td><strong>'.convert::toEuro($projectBruto).'</strong></td>
                                <td></td>
                                <td></td>
                            </tr>
							<tr>
								<td colspan="6"></td>
							</tr>   
        ';
        }           
                        $subTotaal = facturatie::groupByVat($subTotaal, 'btwPercentage');
                        $eindTotaal = 0;
                        foreach($subTotaal as $type => $regels) {
                            $totaalBruto = 0; $totaalBtw = 0; $totaalNetto = 0;
                            for($i=0;$i<count($regels);$i++) {
                                $totaalBruto += $regels[$i]['bruto'];
                                $totaalBtw += ($regels[$i]['bruto'] / 100) * $type;
                                $totaalNetto += $regels[$i]['netto'];
                            }
                            $eindTotaal += $totaalBruto + $totaalBtw;
        
                            $toonTotaalBruto = convert::toEuro($totaalBruto);
                            $toonTotaalBtw = convert::toEuro($totaalBtw);
                            $toonTotaalNetto = convert::toEuro($totaalBruto + $totaalBtw);
        
                    $content .= "
                        <tr>
                            <td colspan=\"3\"></td>
							<td>{$type}% BTW</td>
                            <td>{$toonTotaalBtw}</td>
							<td></td>
                        </tr>"; 
                        }
                $content .= "
                    <tr>
                            <td colspan=\"3\"></td>
							<td><strong>Totaal</strong></td>
                            <td><strong>".convert::toEuro($eindTotaal)."</strong></td>
							<td></td>
                        </tr> 
					</table>
                </div>
				</div>
				</div>";
				$content .= ' 
				<div class="col-4 ps-4 w-100 top-padding">
					<div class="col-2 p-3 w-15">
							<barcode code="https://payments.'.HOST.'/betaling/'.$factuurData->betaalcode.'" type="QR" class="barcode" size="0.7" error="M" disableborder="1">
                	</div>
                    <div class="pt-3">
                        Direct online betalen?<br /> Scan de QR-code of <a href="https://payments.'.HOST.'/betaling/'.$factuurData->betaalcode.'">klik hier</a><br />en betaal direct met iDeal, PayPal, Bancontact of Giropay.
                    </div>
                </div>
        ';
    ?>

<?php
    $input = filter_input(INPUT_POST, "nieuweFactuur");
if(isset($input) && trim($input) != "") {
    $dataset = filter_input_array(INPUT_POST);
    $projecten = json_decode($factuurData->projecten,true);
    try {
        foreach($projecten as $project) {
            $factuurregels[$project] = facturatie::dataPerProject($project);
        }
        
        $factuurregels = json_encode($factuurregels, true);
        $action = facturatie::regelsToevoegen($factuurData->id, $factuurregels);
      
    }
    catch (Exception $e) {
        print "<div class=\"notification error\">Er ging iets fout...: ".$e->getMessage()."</div>";
    }
 
    if(!empty($action)) {
        facturatie::updateStatus($action, 2);
        
        try {
            ob_end_clean();
            $mpdf = new \Mpdf\Mpdf([
                'debug' => true
            ]);
    
            $stylesheet = file_get_contents(STYLE_CSS.'/style.mpdf.css');
            $mpdf->WriteHTML($stylesheet,1);
    
            $mpdf->SetWatermarkImage(SERVER.HOST.'/public_html/images/pdf_background.png');
            $mpdf->showWatermarkImage = true;
            $mpdf->watermarkImgBehind = true;
            $mpdf->watermarkImageAlpha = 1.0;	
    
            $mpdf->WriteHTML($content);
            $pdfPath = '/docs/facturen/Factuur-'.$id.'-'.date('ymd').'.pdf';
            $mpdf->Output(SERVER . HOST .'/public_html'. $pdfPath, 'F');
        } catch (\Mpdf\MpdfException $e) { 
            echo $e->getMessage();
        }
        
        $exportData = array("external_sales_invoice" =>
            array(
                'contact_id' => $relatie->moneybirdId,
                'reference' => $id,
                'date' => convert::datumKort($factuurData->datum),
                'due_date'=> convert::datumKort($factuurData->vervaldatum),
                'currency' => 'EUR',
                'prices_are_incl_tax' => false,
                'source' => 'Portal (ES NextGen)',
                'source_url' => 'https://'.HOST.$pdfPath,
                'details_attributes' => $exportToMb
            )
        );
        $exportData = json_encode($exportData, true);
        $moneybird = new moneybird();
       
        $mbExport = $moneybird->exportMoneybird($exportData);
        $eindTotaal = round($eindTotaal, 2);
        $mbBijlage = $moneybird->exportMoneyBirdBijlage($mbExport->id,SERVER . HOST .'/public_html'. $pdfPath); 
        $dataToevoegen = facturatie::dataToevoegen($factuurData->id, $eindTotaal, $pdfPath, $mbExport->id);
       
        foreach($projecten as $id => $projectNr) {
            $update = projecten::updateStatus($projectNr, "facturatie_verzonden");
        }
        
        if(!empty($dataToevoegen)) {
            $melding = notificaties::verstuurFactuur($dataToevoegen);
            facturatie::updateStatus($dataToevoegen, 3);
            header('Location: /facturatie/verzonden/'.$dataToevoegen);
        }
    }
}
?>
<?php 
    require_once FRAMEWORK;
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">payments</span>
       <span class="text-secondary">Facturatie &nbsp; > &nbsp; Nieuw &nbsp; > &nbsp; </span>
       <span class="">Overzicht</span>
   </h4> 
</div>
<div class="my-4 mx-5 p-4 shadow bg-body rounded">
    <?php 
        print "  
            <div class=\"row\">
                <div class=\"col\">
                    <img src=\"".STYLE_IMAGES."/logo.png\" style=\"height:20px;width:auto;\" class=\"ps-2 mt-3 mb-5\">
                </div>
            </div>
        ";
        print $content; 
    ?>
</div>
     
<div class="row my-4 mx-5 p-4 shadow bg-body rounded">
    <div class="col">
        <form method="post">
            <input type="submit" name="nieuweFactuur" value="Aanmaken" class="btn btn-success float-end" />
        </form>
    </div>
</div>
<?php
  require_once FOOTER;
?>