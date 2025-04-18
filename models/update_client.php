<?php 
   //connexion à la BD
   require('../includes/connexion.php');
   $db = connect_bd();
   
   if(isset($_POST['update'])){
        //récupérer les données mises à jour du formulaire
        $codecli = $_POST['code'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $sexe = $_POST['sexe'];
        $quartier = $_POST['quartier'];
        $niveau = $_POST['niveau'];
        $mail = $_POST['mail'];

        //Mettre à jour un client avec codecli = code
        $stmt = $db->prepare("UPDATE client SET Nom = ?, Prenom = ? , 
                    Sexe = ?, Quartier = ?, Niveau = ?, Mail = ? WHERE CodeCli = ?");
        $stmt->execute([$nom,$prenom,$sexe,$quartier,$niveau,$mail,$codecli]);
        
        //rediriger vers la page Liste des clients
        header('location:../clients.php');
        die();
    }
?> 