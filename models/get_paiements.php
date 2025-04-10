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
		$row = array(
			$payer['Idpaye'], $payer['CodeCli'],
			$payer['Date_paiement'], $payer['Montant'],
			$payer['Etat'], $payer['CodeReleve'],
			'<a href="edit_client.php?code='.$payer['Idpaye'].'" title="Editer" class="edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;'.
			'<button class="btn btn-sm trash mt-2 ml-2 btn-delete-payer" id="'.$payer['Idpaye'].'" type="button"><i class="fa fa-trash-o"></i></button>'
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