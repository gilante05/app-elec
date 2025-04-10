<?php 
    if(!empty($_POST)){
        //récupérer les données mises à jour du formulaire
        $codeReleve = $_POST['code_releve'];
        //$compteurElec = $_POST['compteur_elec'];
        $valeurElec = $_POST['valeur_elec'];
        //$compteurEau = $_POST['compteur_eau'];
        $valeurEau = $_POST['valeur_eau'];
        //$dateReleve = $_POST['date_releve'];
        $datePres = $_POST['date_pres'];
        $dateLimite = $_POST['date_limite'];
        //connexion à la BD
        require('../includes/connexion.php');
        $db = connect_bd();
        //Mettre à jour un releve avec codereleve= code
        $stmt = $db->prepare("UPDATE releve 
                            SET  ValeurElec = ?, ValeurEau = ?, Date_presentation = ?,
                                Date_limite_paiement = ? WHERE CodeReleve = ?");
        $stmt->execute([$valeurElec,$valeurEau,$datePres,$dateLimite,$codeReleve]);
        //rediriger vers la page liste des releves
        header('location:../releves.php');
        die();
    }
    
?> 