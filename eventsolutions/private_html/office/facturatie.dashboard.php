<?php
 $accessLevel = array("admin");
 require_once '../core/system.init.php';
 require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
 require_once FRAMEWORK;
 
 $dataset = facturatie::alleFacturen();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">payments</span>
       Facturatie
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/facturatie/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuwe factuur
          </a>
        </div>
</div>
<input type="text" id="zoekFactuur" onkeyup="zoekFactuur()" placeholder="Zoek op project" class="form-control mb-4">
<table id="alleFacturen" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Project(en)</th>
                        <th>Factuurdatum</th>
                        <th>Relatie</th>
                        <th>Totaal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($dataset as $id => $data) {
                           $projecten = null;
                           $projecten_data = json_decode($data->projecten,true);
                           foreach ($projecten_data as $projectId) {
                               $project = projecten::perProject($projectId)->projectNaam;
                               $projecten .= $project."<br />";
                           }
                           $status = facturatie::statusId($data->status);
                           print
                            "<tr>"
                                . "<td>".$data->nummer."</td>"
                                . "<td>".$projecten."</td>"
                                . "<td>".convert::datumKort($data->datum)."</td>"
                                . "<td>".relaties::perRelatie($data->relatie)->klant_naam."</td>"
                                . "<td>".convert::toEuro($data->totaal)."</td>"
                                . "<td><span class=\"badge px-4 py-2 fw-normal " . $status['style'] . "\">" . $status['txt_badge']."</span></td>"
                            . "</tr>"
                           ; 
                        }
                    ?>
                </tbody>
            </table>
<?php
require_once FOOTER;
?>
<script>
function zoekFactuur() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("zoekFactuur");
  filter = input.value.toUpperCase();
  table = document.getElementById("alleFacturen");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>