<?php 
    //connexion à la BD
    require('../includes/connexion.php');
    $db = connect_bd();

    if(isset($_POST['id'])){
        //récupérer les données du formulaire
        $idPayer = $_POST['id'];

        //update paiement
        $stmt = $db->prepare("UPDATE  payer SET Etat = 1 WHERE Idpaye = ?");
        $res = $stmt->execute([$idPayer]);
        if($res){
            echo "Ce facture a été payé avec succès.";
        }
        else{
            echo "Impossible de payer ce facture.";
        }
        //rediriger vers la page Liste des clients
        //header('location:../paiements.php');
        //die();
    }
?>