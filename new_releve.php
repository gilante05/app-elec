<?php 
    session_start(); 
	if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
	{
		header('location:login.php');
		die();
	}

    require('includes/connexion.php');
    $db = connect_bd();

    $stmt_Elec = $db->prepare("SELECT CodeCompteur FROM  compteur c WHERE c.TypeCompteur = 'ELECTRICITE'");
    $stmt_Elec->execute();
    $resElec = $stmt_Elec->fetchAll(PDO::FETCH_ASSOC);
    $stmt_Eau = $db->prepare("SELECT CodeCompteur FROM  compteur c WHERE c.TypeCompteur = 'EAU'");
    $stmt_Eau->execute();
    $resEau = $stmt_Eau->fetchAll(PDO::FETCH_ASSOC);
?> 
<?php include('includes/header.php'); ?>  
<!-- contenu ici -->
<div class="content-wrapper">
    <div class="container-fluid">
            <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Relevés</li>
        </ol>
        <div class="row">
            <div class="col-12">
                <h1>Nouveau Relevé</h1>
            </div>
            <div class="col-md-8">
                <form action="models/add_releve.php" method="post">
                    <!-- Code Auto-généré
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" name="code_releve" class="form-control">
                    </div>
                    -->
                    <div class="form-group">
                        <label>Compteur Elec</label>
                        <input type="text" name="compteur_elec" class="form-control" list="compteurElec" placeholder="Choisir un compteur">
                        <datalist id="compteurElec">
                                <?php foreach($resElec as $compteur): ?>
                                    <option><?=$compteur['CodeCompteur']?></option>
                                <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Valeur Electricité</label>
                        <input type="number" name="valeur_elec" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Compteur Eau</label>
                        <input type="text" name="compteur_eau" class="form-control" list="compteurEau" placeholder="Choisir un compteur">
                        <datalist id="compteurEau">
                                <?php foreach($resEau as $compteur): ?>
                                    <option><?=$compteur['CodeCompteur']?></option>
                                <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Valeur Eau</label>
                        <input type="number" name="valeur_eau" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Date du relevé</label>
                        <input type="date" name="date_releve" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Date de présentation</label>
                        <input type="date" name="date_pres" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Date de limite de paiement</label>
                        <input type="date" name="date_limite" class="form-control">
                    </div>
                    <input type="submit"  value="Enregistrer" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>  