<?php
	require('../includes/connexion.php');   
	$db = connect_bd();

	$where="";

	if( !empty($_REQUEST['search']['value']) ) { 
		$where.=" WHERE  ( CodeCli LIKE '".$_REQUEST['search']['value']."%' ";    
		$where.=" OR CodeCompteur LIKE '".$_REQUEST['search']['value']."%' )";
	}

	$totalRecordsSql = "SELECT count(*) as total FROM compteur $where";
	$totalRecords = $db->query($totalRecordsSql)->fetchColumn();
	
	$columns = array( 
		0 => 'CodeCompteur', 
		1 => 'CodeCli',
		2 => 'TypeCompteur',
		3 => 'Pu'
	);
	$sql = "SELECT * FROM compteur $where";
	$sql.=" ORDER BY ". $columns[$_REQUEST['order'][0]['column']]."   ".$_REQUEST['order'][0]['dir']."  LIMIT ".$_REQUEST['start']." ,".$_REQUEST['length']."   ";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$compteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$records = array();
	foreach($compteurs as $compteur){
		$row = array(
			$compteur['CodeCompteur'], 
            $compteur['CodeCli'],
            $compteur['TypeCompteur'],
			$compteur['Pu'],
			'<a href="edit_compteur.php?code='.$compteur['CodeCompteur'].'" title="Editer" class="edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;'.
			'<button class="btn btn-sm trash mt-2 ml-2 btn-delete-compteur" id="'.$compteur['CodeCompteur'].'" type="button"><i class="fa fa-trash-o"></i></button>'
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