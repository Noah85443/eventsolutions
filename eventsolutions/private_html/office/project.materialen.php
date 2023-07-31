<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $data_project = projecten::perProject($id);
    $data_verhuur = projectenVerhuur::perProject($data_project->projectNummer);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">fact_check</span>
       <span class="text-secondary">Projecten &nbsp; > &nbsp;
       <?php print $data_project->projectNaam; ?> &nbsp; > &nbsp; </span>
       <span>Verhuur</span>
   </h4> 
</div>
<nav class="mb-5">
    <ul class="nav nav-pills" >
        <li class="nav-item"><a class="nav-link" href="/projecten/overzicht/<?php print $data_project->id; ?>">Overzicht</a></li>       
        <li class="nav-item"><a class="nav-link" href="/projecten/bewerken/<?php print $data_project->id; ?>">Gegevens</a></li>
        <li class="nav-item"><a class="nav-link active" href="/projecten/materialen/<?php print $data_project->id; ?>">Materialen</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/planning/<?php print $data_project->id; ?>">Planning</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/uren/<?php print $data_project->id; ?>">Uren</a></li>
        <li class="nav-item"><a class="nav-link" href="/projecten/declaraties/<?php print $data_project->id; ?>">Declaraties</a></li>
    </ul>
</nav>

<?php if(!empty($data_verhuur)) { ?>
<div class="row">
    <div class="col-sm-4 p-3">
        <h6>Levering</h6>
         <?php print $data_verhuur->aanvoerdatum; ?><br />
         <?php print $data_verhuur->levering_aanvoer; ?>
    </div>
    <div class="col-sm-4 p-3">
        <h6>Huurperiode</h6>
        <?php print $data_verhuur->huurperiode_start; ?> - <?php print $data_verhuur->huurperiode_eind; ?>
    </div>
    <div class="col-sm-4 p-3">
        <h6>Retour</h6>
         <?php print $data_verhuur->retourdatum; ?><br />
         <?php print $data_verhuur->levering_retour; ?>
    </div>
</div>
<div class="row pt-4">
    <div class="col p-3">
        <h6>Verhuurmaterialen</h6>
        <table class="table">
            <thead>
                <tr>
                    <td>id</td>
                    <td>aantal</td>
                    <td>naam</td>
                    <td>prijs</td>
                    <td>korting</td>
                    <td>factor</td>
                    <td>btw</td>
                    <td>type</td>
                </tr>
            </thead>
        <?php 
            $artikelen = json_decode($data_verhuur->artikelen);
            for($x=0;$x<count($artikelen);$x++) {
                print ""
                . "<tr>"
                    . "<td>{$artikelen[$x]->artikel_id}</td>"
                    . "<td>{$artikelen[$x]->aantal}</td>"
                    . "<td>{$artikelen[$x]->naam}</td>"
                    . "<td>{$artikelen[$x]->prijs}</td>"
                    . "<td>{$artikelen[$x]->korting}</td>"
                    . "<td>{$artikelen[$x]->factor}</td>"
                    . "<td>{$artikelen[$x]->btw}</td>"
                    . "<td>{$artikelen[$x]->type}</td>"
                . "</tr>";
            }
        ?>
        </table>
    </div>
</div>
<?php
}
else {
    print "nog geen verhuurmaterialen toegevoegd.";
}
 require_once FOOTER;