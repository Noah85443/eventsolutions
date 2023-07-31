<?php
require_once '../core/system.init.php';
require_once ROOT_ACCOUNTS . ACCOUNT_CHECK;
require_once FRAMEWORK;

$data = $account->getAllUsers();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
   <h4>
       <span class="material-icons-outlined icon">people</span>
       <span class="text-secondary">Accounts &nbsp; > &nbsp; </span>
       <span>Alle gebruikers</span>
   </h4>
       <div class="btn-toolbar mb-2 mb-md-0">
          <a href="<?php print BASE_ACCOUNTS.'/nieuw'; ?>" class="btn btn-outline-success">
            <span class="material-icons-outlined float-start pe-2">add</span>
            Nieuwe gebruiker
          </a>
        </div>
</div>
<table class="table">
            <tr>
                <th>ID</th>
                <th>Gebruikersnaam</th>
                <th>Contactpersoon</th>
                <th>Laatste login</th>
                <th>Type</th>
                <th>Geactiveerd</th>
                <th colspan="2">Functies</th>
            </tr>
            <?php 
            for($x=0; $x < count($data); $x++) {
                print "<tr>";
                    print "<td>".$data[$x]->account_id."</td>";
                    print "<td><a href=\"/overzicht/".$data[$x]->account_id."\">".$data[$x]->account_name."</a></td>";
                    print "<td>".$data[$x]->account_realname."</td>";
                    print "<td>".$data[$x]->account_lastlogin."</td>";
                    print "<td>".$data[$x]->account_type."</td>";
                    print "<td>".$data[$x]->account_enabled."</td>";
                    print "<td><a href=\"/bewerken/".$data[$x]->account_id."\"><i class=\"material-icons\">edit</i></a></td>";
                    print "<td><a href=\"/verwijderen/".$data[$x]->account_id."\"><i class=\"material-icons\">delete</i></a></td>";
                print "</tr>";
            }
            ?>
        </table>
<?php
 require_once FOOTER;
