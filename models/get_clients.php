<?php
	require('../includes/connexion.php');   
	$db = connect_bd();

	$where="";

	if( !empty($_REQUEST['search']['value']) ) { 
		$where.=" WHERE  ( CodeCli LIKE '".$_REQUEST['search']['value']."%' ";    
		$where.=" OR Nom LIKE '".$_REQUEST['search']['value']."%' ";
		$where.=" OR Quartier LIKE '".$_REQUEST['search']['value']."%' )";
	}

	$totalRecordsSql = "SELECT count(*) as total FROM client $where";
	$totalRecords = $db->query($totalRecordsSql)->fetchColumn();
	
	$columns = array( 
		0 => 'CodeCli', 
		1 => 'Nom',
		2 => 'Prenom',
		3 => 'Sexe',
		4 => 'Quartier',
		5 => 'Niveau',
		6 => 'Mail'
	);
	$sql = "SELECT * FROM client $where";
	$sql.=" ORDER BY ". $columns[$_REQUEST['order'][0]['column']]."   ".$_REQUEST['order'][0]['dir']."  LIMIT ".$_REQUEST['start']." ,".$_REQUEST['length']."   ";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$records = array();
	foreach($clients as $client){
		$row = array(
			$client['CodeCli'], $client['Nom']." ".$client['Prenom'],$client['Sexe'],
			$client['Quartier'],$client['Niveau'],$client['Mail'],
			'<a href="edit_client.php?code='.$client['CodeCli'].'" title="Editer" class="edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;'.
			'<button class="btn btn-sm trash mt-2 ml-2 btn-delete-client" id="'.$client['CodeCli'].'" type="button"><i class="fa fa-trash-o"></i></button>'
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