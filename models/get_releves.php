<?php
	require('../includes/connexion.php');   
	$db = connect_bd();

	$where="";

	if( !empty($_REQUEST['search']['value']) ) { 
		$where.=" WHERE  ( Date_releve LIKE '".$_REQUEST['search']['value']."%' ";    
		$where.=" OR CompteurElec LIKE '".$_REQUEST['search']['value']."%' ";
        $where.=" OR CompteurEau LIKE '".$_REQUEST['search']['value']."%' ";
        $where.=" OR Date_presentation LIKE '".$_REQUEST['search']['value']."%' ";
		$where.=" OR Date_releve LIKE '".$_REQUEST['search']['value']."%' )";
	}

	$totalRecordsSql = "SELECT count(*) as total FROM releve $where";
	$totalRecords = $db->query($totalRecordsSql)->fetchColumn();
	
	$columns = array( 
		0 => 'CodeReleve', 
		1 => 'CompteurElec',
		2 => 'ValeurElec',
		3 => 'CompteurEau',
		4 => 'ValeurEau',
		5 => 'Date_releve',
		6 => 'Date_presentation',
        7 => 'Date_limite_paiement'
	);
	$sql = "SELECT * FROM releve $where";
	$sql.=" ORDER BY ". $columns[$_REQUEST['order'][0]['column']]."   ".$_REQUEST['order'][0]['dir']."  LIMIT ".$_REQUEST['start']." ,".$_REQUEST['length']."   ";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$releves = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$records = array();
	foreach($releves as $releve){
		$row = array(
			$releve['CodeReleve'], $releve['CompteurElec'],$releve['ValeurElec'],$releve['CompteurEau'],
			$releve['ValeurEau'],$releve['Date_releve'],$releve['Date_presentation'],$releve['Date_limite_paiement'],
			'<a href="edit_releve.php?code='.$releve['CodeReleve'].'" title="Editer" class="edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;'.
			'<button class="btn btn-sm trash mt-2 ml-2 btn-delete-releve" id="'.$releve['CodeReleve'].'" type="button"><i class="fa fa-trash-o"></i></button>'
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