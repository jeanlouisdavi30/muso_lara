<?php
if(isset($_POST['get_option']))
{
   $db = new mysqli('localhost', 'root' ,'', 'muso');
	if(!$db) {

		echo 'Could not connect to the database.';
	} else {

        		$id = $_POST['get_option'];
				
        		$query0 = $db->query("SELECT *  FROM paiement_emprunts WHERE  id_emprunt_apayers = '$id' order by id desc LIMIT 1");
				if($query0) {
						while ($result0 = $query0->fetch_object()) {
								 $balance = $result0->balance_versement;
						}
				}
        		$query = $db->query("SELECT *  FROM emprunt_apayers WHERE  emprunts_id = '$id' And paiement = 'false' LIMIT 1");
				if($query) {
			
					while ($result = $query ->fetch_object()) {

						if(!empty($balance) and  $balance != 0 ){
							echo " <label for='exampleInputEmail1'>Montant Totatl paye</label>
						 <input type='text' onkeyup='sumeBalance();' name='montant' class='form-control' id='mpayeb'>
							
							<label for='exampleInputEmail1'>interet Paye</label>
						 <input type='text' onkeyup='sumeBalance();' name='interet_payer' class='form-control' id='interetBalance' value='0' >
						 
						 <label for='exampleInputEmail1'>Principale Paye </label>
						 <input type='text' onkeyup='sumeBalance();' name='principale_payer' class='form-control' id='balance' value='$balance' >
						 							 
						 <input type='hidden' onkeyup='sumeEmprunt();' class='form-control' name='id' value='$result->id' >

						 <label for='exampleInputEmail1'>Balance du sur versement</label>
						 <input type='text' onkeyup='sumeBalance();' name='balance_versement' class='form-control' id='balance_ver_b' >
						
						 <input type='hidden'  name='date_paiement' value='$result->date_paiement'>
						 <input type='hidden' onkeyup='sumeBalance();' class='form-control' id='balanceBN' value='$balance'' >";
						}else{
							 echo " <label for='exampleInputEmail1'>Montant Totatl paye</label>
						 <input type='text' onkeyup='sumeEmprunt();' name='montant' class='form-control' id='mpaye'>
						 
						 <label for='exampleInputEmail1'>interet Paye</label>
						 <input type='text' onkeyup='sumeEmprunt();' name='interet_payer' class='form-control' id='inmensuel' >
							
						 <label for='exampleInputEmail1'>Principale Paye </label>
							 <input type='text' onkeyup='sumeEmprunt();' name='principale_payer' class='form-control' id='ppayer' value='$result->pmensuel' >
							 						
							 <label for='exampleInputEmail1'>Balance du sur versement</label>
						 <input type='text' onkeyup='sumeEmprunt();' name='balance_versement' class='form-control' id='balance_ver' >
<input type='hidden'  name='date_paiement' value='$result->date_paiement'>
							 <input type='hidden' onkeyup='sumeEmprunt();' class='form-control' id='ttalmensuel' value='$result->ttalmensuel' >
							 <input type='hidden' onkeyup='sumeEmprunt();' class='form-control' name='id' value='$result->id' >
							 <input type='hidden' onkeyup='sumeEmprunt();' class='form-control' id='intere_mensuel' value='$result->intere_mensuel' >";
	         			}
				}
				
					
				} else {
					echo 'OOPS we had a problem :(';
				}
    }
}
?>