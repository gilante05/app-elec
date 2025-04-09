<?php 
    //connexion à la BD
    require('../includes/connexion.php');
    $db = connect_bd();

    if(!empty($_POST)){
        //récupérer les données du formulaire
        $codecompteur = $_POST['code'];
        $type = $_POST['type'];
        $pu = $_POST['pu'];
        $client = $_POST['client'];
        
        $stmt = $db->prepare("INSERT INTO compteur VALUES(?,?,?,?)");
        $stmt->execute([$codecompteur, $client,$type,$pu]);

        //rediriger vers la page Liste des clients
        header('location:../compteurs.php');
        die();
    }
?>