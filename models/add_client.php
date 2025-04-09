<?php 
    //connexion à la BD
    require('../includes/connexion.php');
    $db = connect_bd();

    if(isset($_POST['add'])){
        //récupérer les données du formulaire
        $codecli = $_POST['code'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $sexe = $_POST['sexe'];
        $quartier = $_POST['quartier'];
        $niveau = $_POST['niveau'];
        $mail = $_POST['mail'];

        //Insérer dans la table client
        $stmt = $db->prepare("INSERT INTO client VALUES(?,?,?,?,?,?,?)");
        $stmt->execute([$codecli, $nom,$prenom,$sexe,$quartier,$niveau,$mail]);

        //rediriger vers la page Liste des clients
        header('location:../clients.php');
        die();
    }
?>