<?php 
    //https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/

    require('../includes/connexion.php');
    
    $db = connect_bd();
    
    if (isset($_POST['code'])) {
        // supprimer ce client si l'Utilisateur a cliqué sur le bouton Confirm
        $stmt = $db->prepare('DELETE FROM client WHERE CodeCli = ?');
        $res = $stmt->execute([$_POST['code']]);
        if($res){
            echo "Employee has been deleted.";
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
?> 