<?php 
    session_start(); 
	if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
	{
		header('location:login.php');
		die();
	}
?> 
<?php include('includes/header.php'); ?>  
<!-- contenu ici -->
<div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Clients</li>
            </ol>
            <div class="row">
                <div class="col-12">
                    <h1>Nouveau Client</h1>
                </div>
                <div class="col-md-8">
                    <form action="models/add_client.php" method="post">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Prénom</label>
                            <input type="text" name="prenom" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sexe</label>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <input type="radio" name="sexe" value="Masculin" checked >Macsulin
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" name="sexe" value="Féminin">Féminin
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Quartier</label>
                            <input type="text" name="quartier" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Niveau</label>
                            <select  name="niveau" class="form-control">
                                <option value="VIP">VIP</option>
                                <option value="REGULIER">REGULIER</option>
                                <option value="FIDELE">FIDELE</option>
                                <option value="NOUVEAU">NOUVEAU</option>         
                            </select>
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="mail" name="mail" class="form-control">
                        </div>
                        <input type="submit"  value="Enregistrer" name="add" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include('includes/footer.php'); ?>          