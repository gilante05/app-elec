<?php
    session_start(); 
	if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
	{
		header('location:login.php');
		die();
	}
    if(!empty($_GET['code'])){

        $compteur = $_GET['code'];
        $titre = "Edition d'un client";
        require('includes/connexion.php');
        $db = connect_bd();
        $stmt = $db->prepare("SELECT * FROM compteur WHERE CodeCompteur = :code");
        $stmt->bindValue(':code', $compteur);
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        //get and print results
        $compteur = $stmt->fetch();
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
            <li class="breadcrumb-item active">Compteurs</li>
        </ol>
        <div class="col-12">
            <h1>Edition d'un Compteur</h1>
        </div>
        <div class="col-md-8">
                <form action="update_compteur.php" method="post">
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" name="code" value="<?=$compteur['CodeCompteur']?>" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Client</label>
                        <input type="text" name="client" value="<?=$compteur['CodeCli']?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <div>
                            <input type="radio" name="type" 
                                    value="EAU" <?php if($compteur['TypeCompteur']=='EAU') echo 'checked';?> >EAU
                            <input type="radio" name="type" 
                                    value="ELECTRICITE" <?php if($compteur['TypeCompteur']=='ELECTRICITE') echo 'checked';?> >ELECTRICITE
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Prix unitaire</label>
                        <input type="number" name="pu" value="<?=$compteur['Pu']?>" class="form-control">
                    </div>
                    <input type="submit"  value="Enregistrer" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>    