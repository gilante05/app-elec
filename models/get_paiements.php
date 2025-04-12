<?php
	require('../includes/connexion.php');   
	$db = connect_bd();

	$where="";

	if( !empty($_REQUEST['search']['value']) ) { 
		$where.=" WHERE  ( CodeCli LIKE '".$_REQUEST['search']['value']."%' ";    
		$where.=" OR CodeReleve LIKE '".$_REQUEST['search']['value']."%' ";
		$where.=" OR Etat LIKE '".$_REQUEST['search']['value']."%' )";
	}

	$totalRecordsSql = "SELECT count(*) as total FROM payer $where";
	$totalRecords = $db->query($totalRecordsSql)->fetchColumn();
	
	$columns = array( 
		0 => 'Idpaye', 
		1 => 'CodeCli',
		2 => 'Date_paiement',
		3 => 'Montant',
		4 => 'Etat',
		5 => 'CodeReleve'
	);
	$sql = "SELECT * FROM payer $where";
	$sql.=" ORDER BY ". $columns[$_REQUEST['order'][0]['column']]."   ".$_REQUEST['order'][0]['dir']."  LIMIT ".$_REQUEST['start']." ,".$_REQUEST['length']."   ";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$payers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$records = array();
	foreach($payers as $payer){
		$etat = ($payer['Etat']==1)? 'Payé': 'impayé';
		$btn_status = ($payer['Etat']==1)? 'disabled': '';
		$row = array(
			$payer['Idpaye'], $payer['CodeCli'],
			$payer['Date_paiement'], $payer['Montant'],
			$etat, $payer['CodeReleve'],
			'<button class="btn btn-sm  mt-2 ml-2 btn-payer" id="'.$payer['Idpaye'].'" type="button" '. $btn_status. ' title="Payer" ><i class="fa fa-cubes "></i></button> &nbsp;&nbsp;&nbsp;'.
			'<form action="print.php" method="post" style="display:inline-block;">
				<input type="hidden" name="id_payer" value="'.$payer['Idpaye'].'">
				<input type="hidden" name="date_payer" value="'.$payer['Date_paiement'].'">
				<button class="btn btn-sm  mt-2 ml-2 btn-print-facture" id="" type="submit" title="Imprimer facture"><i class="fa fa-print "></i></button>
			</form>'
		);
		$records[] = $row; 
	}

	$json_data = array(
		"draw"            => intval( $_REQUEST['draw'] ),   
		"recordsTotal"    => intval($totalRecords ),  
		"recordsFiltered" => intval($totalRecords),
		"data"            => $records 
	);

	echo json_encode($json_data);
?>