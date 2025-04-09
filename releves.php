<?php 
    session_start(); 
	if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
	{
		header('location:login.php');
		die();
	}
    require('includes/connexion.php');
    
    $db = connect_bd();
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    // Number of records to show on each page
    $records_per_page = 5;
    
    $num_releves = $db->query('SELECT COUNT(*) FROM releve')->fetchColumn();
    $stmt = $db->prepare('SELECT * FROM releve ORDER BY CodeReleve LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $releves = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //include('includes/utils.php');
?> 
<!-- insérer header ici -->
<?php include('includes/header.php'); ?>
<!-- contenu va ici -->
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Relevés</li>
        </ol>
      <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Liste des relevés
            </div>
            <div class="card-body">
                <a href="add_releve.php" class="btn btn-primary"> Nouveau</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Compteur Elec</th>
                                <th>Valeur Elec </th>
                                <th>Compteur Eau</th>
                                <th>Valeur Eau</th>
                                <th>Date de relevé</th>
                                <th>Date de présentation</th>
                                <th>Date de limite de paiement</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($releves): 
                            foreach($releves as $releve): ?>
                            <tr>
                                <td><?=$releve['CodeReleve'];?></td>
                                <td><?=$releve['CompteurElec'];?></td>
                                <td><?=$releve['ValeurElec'];?></td>
                                <td><?=$releve['CompteurEau'];?></td>
                                <td><?=$releve['ValeurEau'];?></td>
                                <td><?=$releve['Date_releve'];?></td>
                                <td><?=$releve['Date_presentation'];?></td>
                                <td><?=$releve['Date_limite_paiement'];?></td>
                                <td><a href="edit_releve.php?code=<?=$releve['CodeReleve'];?>"><i class="fa fa-pencil"></i></a></td>
                                <td><a href="delete_releve.php?code=<?=$releve['CodeReleve'];?>"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="8" style="text-align:center;">Pas de données à afficher</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer -->
<?php include('includes/footer.php'); ?>
