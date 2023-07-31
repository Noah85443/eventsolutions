<?php 
    require_once './core/system.init.php'; 

?>
<!doctype html>
<html lang="en">
    <?php require_once header; ?>  
    <body>
	<?php require_once navigation; ?>
        <div class="container">
            <div class="row text-center">
                <h3>Openingstijden</h3>
            </div>
            <div class="row">
                <table>
                	<tr>
                    	<td width="150px"></td>
                        <td width="150px">Kantoor</td>
                        <td width="150px">Magazijn</td>
                        <td><br /><br /></td>
                    </tr>
                    <tr>
                    	<td>Maandag</td>
                        <td>09.00 - 19.00</td>
                        <td>09.00 - 19.00</td>
                        <td><br /><br /></td>
                    </tr>
                    <tr>
                    	<td>Dinsdag</td>
                        <td>09.00 - 19.00</td>
                        <td>09.00 - 19.00</td>
                        <td><br /><br /></td>
                    </tr>
                    <tr>
                    	<td>Woensdag</td>
                        <td>09.00 - 19.00</td>
                        <td>09.00 - 19.00</td>
                        <td><br /><br /></td>
                    </tr>
                    <tr>
                    	<td>Donderdag</td>
                        <td>09.00 - 19.00</td>
                        <td>09.00 - 19.00</td>
                        <td><br /><br /></td>
                    </tr>
                    <tr>
                    	<td>Vrijdag</td>
                        <td>09.00 - 19.00</td>
                        <td>09.00 - 19.00</td>
                        <td><br /><br /></td>
                    </tr>
                    <tr>
                    	<td>Zaterdag</td>
                        <td></td>
                        <td>Op afspraak</td>
                        <td><br /><br /></td>
                    </tr>
                    <tr>
                    	<td>Zondag</td>
                        <td></td>
                        <td>Op afspraak</td>
                        <td><br /><br /></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php require_once footer; ?>
        <?php require_once scripts; ?>
    </body>
</html>