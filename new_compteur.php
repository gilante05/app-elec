<?php 
    session_start(); 
	if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
	{
		header('location:login.php');
		die();
	}
    
    require('includes/connexion.php');
    $db = connect_bd();
    $stmt = $db->prepare("SELECT CodeCli,Nom,Prenom FROM client");
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

?> 
<!-- header ici -->
<?php include('includes/header.php'); ?>  
<!-- contenu ici -->
<div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Compteurs</li>
            </ol>
            <div class="row">
                <div class="col-12">
                    <h1>Nouveau Compteur</h1>
                </div>
                <div class="col-md-8">
            <form action="models/add_compteur.php" method="post">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control">
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select  name="type" class="form-control">
                        <option value="">Choisir type</option>
                        <option value="ELECTRICITE">ELECTRICITE</option>
                        <option value="EAU">EAU</option>         
                    </select>
                </div>
                <div class="form-group">
                    <label>Prix unitaire</label>
                    <input type="number" name="pu" class="form-control">
                </div>
                <div class="form-group">
                    <label>Client</label>
                    <select  name="client" class="form-control">
                        <option value="">Choisir un client</option>
                        <?php foreach($clients as $client): ?>
                        <option value="<?=$client['CodeCli']?>"><?=$client['Nom'].' '.$client['Prenom']?></option>   
                        <?php endforeach; ?>      
                    </select>
                </div>
                <input type="submit"  value="Enregistrer" class="btn btn-primary">
            </form>
            </div>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>  