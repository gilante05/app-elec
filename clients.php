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
    $num_clients = $db->query('SELECT COUNT(*) FROM client')->fetchColumn();

    $stmt = $db->prepare('SELECT * FROM client ORDER BY CodeCli LIMIT :current_page, :record_per_page');
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //include('includes/utils.php');
?> 
<?php include('includes/header.php'); ?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Clients</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-table"></i> Liste des clients</div>
        <div class="card-body">
            <a href="add_client.php" class="btn btn-primary"> Nouveau</a>
            <div class="table-responsive">
                <!-- Table here-->
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Sexe</th>
                            <th>Quartier</th>
                            <th>Niveau</th>
                            <th>E-mail</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Sexe</th>
                            <th>Quartier</th>
                            <th>Niveau</th>
                            <th>E-mail</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach($clients as $client): ?>
                            <tr>
                                <td> <?=$client['CodeCli'];?></td>
                                <td><?=$client['Nom'];?></td>
                                <td><?=$client['Prenom'];?></td>
                                <td><?=$client['Sexe'];?></td>
                                <td><?=$client['Quartier'];?></td>
                                <td><?=$client['Niveau'];?></td>
                                <td><?=$client['Mail'];?></td>
                                <td><a href="edit_client.php?code=<?=$client['CodeCli'];?>" title="Editer" class="edit"><i class="fa fa-pencil"></i></a></td>
                                <td><a href="delete_client.php?code=<?=$client['CodeCli'];?>" title="Supprimer" class="trash"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                    <?php endforeach;?>
                    </tbody>
                </table> <!-- End of table -->
                <div class="card-footer small text-muted"><?php if ($page > 1): ?> 
                    <a href="clients.php?page=<?=$page-1?>"><i class="fa fa-fast-backward"></i></a>
                    <?php endif; ?>
                    <?php if ($page*$records_per_page < $num_clients): ?>
                    <a href="clients.php?page=<?=$page+1?>"><i class="fa fa-fast-forward"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php include('includes/footer.php'); ?>          