<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $dataset = verhuurEmballage::alleEmballage();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">category</span>
       <span class="text-secondary">Verhuur &nbsp; > &nbsp;</span>
       <span>Emballage</span>
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/verhuur/emballage/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuw emballageproduct
          </a>
        </div>
</div>
<input type="text" id="zoekProduct" onkeyup="zoekProduct()" placeholder="Zoeken op artikelgroepnaam" class="form-control mb-4">

            <table id="alleProducten" class="table">
                <thead>
                    <tr>
                        <th>Artikelnr</th>
                        <th>Naam</th>
                        <th>Aantal</th>
                        <th>Formaat (cm)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($dataset as $id => $data) {
                           $formaat = json_decode($data->formaat);
                           print
                            "<tr>"
                                . "<td>".$data->artikelNr."</td>"
                                . "<td>".$data->naam."</td>"
                                . "<td>".$data->aantal."</td>"
                                . "<td>".$formaat->lengte."(L) x ".$formaat->breedte."(B) x ".$formaat->hoogte."(H)</td>"
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