<?php
    $accessLevel = array("admin");
    require_once '../core/system.init.php';
    require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
    require_once FRAMEWORK;
 
    $dataset = verhuurArtikelen::alleArtikelen();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">category</span>
       <span class="text-secondary">Verhuur &nbsp; > &nbsp;</span>
       <span>Artikelen</span>
   </h4> 
   <div class="btn-toolbar mb-2 mb-md-0">
          <a href="/projecten/nieuw" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuw project
          </a>
        </div>
</div>
<input type="text" id="zoekProduct" onkeyup="zoekProduct()" placeholder="Zoeken op projectnaam of projectnummer" class="form-control mb-4">

            <table id="alleProducten" class="table">
                <thead>
                    <tr>
                        <th>Artikelnr</th>
                        <th>Naam</th>
                        <th>Artikelgroep</th>
                        <th>Artikelsoort</th>
                        <th>Toon</th>
                        <th>Prijs</th>
                        <th>Manco</th>
                        <th>Voorraad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($dataset as $id => $data) {
                           if ($data->toonOpWebsite == "true") {$toonOpWebsite = '<i class="material-icons green-text text-lighten-3">check_box</i>';}
                           else {$toonOpWebsite = '<i class="material-icons red-text text-lighten-3">disabled_by_default</i>';}
                           print
                            "<tr class=\"artikel\" data-href=\"/verhuur/artikel/".$data->id."\">"
                                . "<td>".$data->artikelnr."</td>"
                                . "<td>".$data->artikelnaam."</td>"
                                . "<td>".$data->artikelgroep."</td>"
                                . "<td>".$data->artikelsoort."</td>"
                                . "<td>".$toonOpWebsite."</td>"
                                . "<td>".$data->prijsEuro."</td>"
                                . "<td>".$data->mancoprijsEuro."</td>"
                                . "<td>".$data->aantal."</td>"
                                . "<td><a href=\"/verhuur/artikel/".$data->id."/bewerken\"><i class=\"material-icons orange-text text-lighten-3\">edit</i></a></td>"
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

jQuery(document).ready(function($) {
    $(".artikel").click(function() {
        window.location = $(this).data("href");
    });
});
</script>
<style>
    table tr.artikel:hover {
        background: #F2F3F4;
    }
</style>