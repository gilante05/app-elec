<?php 
    //https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/
    session_start(); 
     if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
     {
         header('location:login.php');
         die();
     }
    
    if(!empty($_POST)){
        //récupérer les données mises à jour du formulaire
        $codereleve = $_POST['code'];
        $codecompteur = $_POST['compteur'];
        $valeur = $_POST['valeur'];
        $datereleve = $_POST['datereleve'];
        $datepresentation = $_POST['datepresentation'];
        $datelimite = $_POST['datelimite'];
        //connexion à la BD
        require('includes/connexion.php');
        $db = connect_bd();
        //Mettre à jour un releve avec codereleve= code
        $stmt = $db->prepare("UPDATE releve SET   
                      CodeCompteur= ?, Valeur = ?, Date_releve = ?, Date_presentation = ?,
                      Date_limite_paiement = ? WHERE CodeReleve = ?");
        $stmt->execute([$codecompteur,$valeur,$datereleve,$datepresentation,$datelimite,$codereleve]);
        //rediriger vers la page liste des releves
        header('location:releves.php');
        die();
    }
    
?> 