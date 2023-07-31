<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $dataset = projectenVerhuur::alleProjecten();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">category</span>
       <span class="text-secondary">Verhuur &nbsp; > &nbsp;</span>
       <span>Projecten</span>
       
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/projecten/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuw project
          </a>
        </div>
</div>
<input type="text" id="zoekProject" onkeyup="zoekProject()" placeholder="Zoeken op projectnaam of projectnummer" class="form-control mb-4">

            <table id="alleProjecten" class="table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Project</th>
                        <th>Levering</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($dataset as $id => $data) {
                          $status = $data->status;
                          print
                            "<tr class=\"project\" data-href=\"/verhuur/project/".$data->id."\">"
                                . "<td>".$data->projectNummer."</td>"
                                . "<td>".$data->levering_aanvoer."<br />".$data->levering_retour."</td>"
                                . "<td>".convert::datumKort($data->aanvoerdatum)." - ".convert::datumKort($data->retourdatum)."</td>"
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
function zoekProject() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("zoekProject");
  filter = input.value.toUpperCase();
  table = document.getElementById("alleProjecten");
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

jQuery(document).ready(function($) {
    $(".project").click(function() {
        window.location = $(this).data("href");
    });
});
</script>