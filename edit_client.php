<?php
    session_start(); 
	if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
	{
		header('location:login.php');
		die();
	}
    if(!empty($_GET['code'])){

        $codecli = $_GET['code'];
        $titre = "Edition d'un client";
        require('includes/connexion.php');
        $db = connect_bd();
        $stmt = $db->prepare("SELECT * FROM client WHERE CodeCli = :code");
        $stmt->bindValue(':code', $codecli);
        $stmt->execute();
        // set the resulting array to associative
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        //get and print results
        $client = $stmt->fetch();
    }
    //include('includes/utils.php');
    $niveaux = array('VIP','REGULIER','FIDELE','NOUVEAU');
?>
<!-- insérer header ici -->
<?php include('includes/header.php'); ?>  
<!-- contenu ici -->
<div class="content-wrapper">
    <div class="container-fluid">
            <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Clients</li>
        </ol>
        <div class="col-12">
            <h1>Edition d'un Client</h1>
        </div>
        <div class="col-md-8">
            <form action="update_client.php" method="post">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" name="code" value="<?=$client['CodeCli']?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?=$client['Nom']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="<?=$client['Prenom']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Sexe</label>
                    <div>
                        <input type="radio" name="sexe" 
                                value="Masculin" <?php if($client['Sexe']=='MASCULIN') echo 'checked';?> >Macsulin
                        <input type="radio" name="sexe" 
                                value="Féminin" <?php if($client['Sexe']=='FEMININ') echo 'checked';?> >Féminin
                    </div>
                </div>
                <div class="form-group">
                    <label>Quartier</label>
                    <input type="text" name="quartier" value="<?=$client['Quartier']?>" >
                </div>
                <div class="form-group">
                    <label>Niveau</label>
                    <select  name="niveau" class="form-control">
                    <?php foreach($niveaux as $n): ?>
                        <option value="<?=$n?>" <?php if($client['Niveau']==$n) echo 'selected';?> >
                            <?=$n?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="mail" name="mail" value="<?=$client['Mail']?>" class="form-control">
                </div>
                <input type="submit"  value="Enregistrer" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>          