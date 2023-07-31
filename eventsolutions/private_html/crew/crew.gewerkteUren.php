<?php
$accessLevel = array("crew");
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;

$data = crewUren::perMedewerker($userData->linked_crew);

?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">schedule</span>
       Urenoverzicht
   </h4> 
    <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/uren-toevoegen" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Uren toevoegen
          </a>
        </div>
</div>
<?php 
for($x=0; $x<count($data); $x++) { ?>
    <div class="row bg-secondary-subtle rounded-3 p-4 mb-4">
        <div class="col-12 mb-3">
            <h6><?php print $data[$x]['dienstNaam']; ?></h6>
            <?php
                print $data[$x]['project']; 
            ?>
        </div>
        <div class="col-12">
            <div class="list-group">
                <div class="list-group-item py-4 hstack gap-0">
                    <div class="col-4 ms-3">
                        <?php 
                            print '<span class="fw-semibold">'.$data[$x]['uren']['datum'].'</span><br />'.
                            convert::tijdKort($data[$x]['uren']['begin']) . ' - ' . convert::tijdKort($data[$x]['uren']['eind']); 
                        ?> 
                    </div>
                    <div class="col-4">
                        <?php
                            print 'Totaal uren: ' . $data[$x]['uren']['totaal'].'<br />';
                            print 'Pauze: ' . $data[$x]['uren']['pauze'];
                        ?>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
 require_once FOOTER;
?>
