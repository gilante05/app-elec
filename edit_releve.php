<?php
    session_start(); 
	if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
	{
		header('location:login.php');
		die();
	}
    if(!empty($_GET['code'])){

        $releve = $_GET['code'];
        $titre = "Edition d'un relevé";
        require('includes/connexion.php');
        $db = connect_bd();
        $stmt = $db->prepare("SELECT * FROM releve WHERE CodeReleve = :code");
        $stmt->bindValue(':code', $releve);
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        //get and print results
        $releve = $stmt->fetch();
    }
    //include('includes/utils.php');
   
?>
<!-- insérer header ici -->
<?php include('includes/header.php'); ?>  
<!-- contenu ici -->
<div class="content-wrapper">
    <div class="container-fluid">
            <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Releves</li>
        </ol>
        <div class="col-12">
            <h1>Edition d'un Relevé</h1>
        </div>
        <div class="col-md-8">
            <form action="models/update_releve.php" method="post">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" name="code" value="<?=$releve['CodeReleve']?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Compteur</label>
                    <input type="text" name="compteur" value="<?=$releve['CodeCompteur']?>" class="form-control" readonly >
                </div>
                <div class="form-group">
                    <label>Valeur</label>
                    <input type="number"  min="0" name="valeur" value="<?=$releve['Valeur']?>" class="form-control" >
                </div>
                <div class="form-group">
                    <label>Date du relevé</label>
                    <input type="date" name="datereleve" value="<?=$releve['Date_releve']?>"  class="form-control">
                </div>
                <div class="form-group">
                    <label>Date du présentation</label>
                    <input type="date" name="datepresentation" value="<?=$releve['Date_presentation']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Date du limite de paiment</label>
                    <input type="date" name="datelimite" value="<?=$releve['Date_limite_paiement']?>" class="form-control" >
                </div>
                <input type="submit"  value="Enregistrer" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>    