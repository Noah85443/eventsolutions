<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $dataset = verhuurArtikelgroepen::alleArtikelgroepen();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">category</span>
       <span class="text-secondary">Verhuur &nbsp; > &nbsp;</span>
       <span>Artikelgroepen</span>
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/verhuur/artikelgroepen/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuwe artikelgroep
          </a>
        </div>
</div>
<input type="text" id="zoekProduct" onkeyup="zoekProduct()" placeholder="Zoeken op artikelgroepnaam" class="form-control mb-4">

            <table id="alleProducten" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Bovenliggend</th>
                        <th>Alias</th>
                        <th>Op Voorpagina</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($dataset as $id => $data) {
                           print
                            "<tr>"
                                . "<td>".$data->id."</td>"
                                . "<td>".$data->naam."</td>"
                                . "<td>".$data->toplevel."</td>"
                                . "<td>".$data->alias."</td>"
                                . "<td>".$data->opVoorpagina."</td>"
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
function zoekProduct() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("zoekProduct");
  filter = input.value.toUpperCase();
  table = document.getElementById("alleProducten");
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