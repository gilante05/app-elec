<?php
    require('../includes/connexion.php');
    $db = connect_bd();

    if(!empty($_POST)){
        //récupérer les données du formulaire
        $compteurElec = $_POST['compteur_elec'];
        $valeurElec = floatval($_POST['valeur_elec']);
        $compteurEau = $_POST['compteur_eau'];
        $valeurEau = floatval($_POST['valeur_eau']);
        $dateReleve = $_POST['date_releve'];
        $datePres = $_POST['date_pres'];
        $dateLimite = $_POST['date_limite'];
        $codeReleve = $_POST['code_releve'];
        
        $stmt = $db->prepare("INSERT INTO releve VALUES(?,?,?,?,?,?,?,?)");
        $InsertReleve = $stmt->execute([
                                $codeReleve, $compteurElec,$valeurElec,
                                $compteurEau,$valeurEau,$dateReleve,
                                $datePres,$dateLimite
                             ]);

        if($InsertReleve){
            $puElec = $puEau = 0;
            $codeCli = '';
            if(!empty($compteurElec)){
                $stmt = $db->prepare("SELECT CodeCli, Pu FROM  compteur WHERE CodeCompteur = ? AND TypeCompteur='ELECTRICITE'");
                $stmt->execute([$compteurElec]);
                $compteur = $stmt->fetch(PDO::FETCH_ASSOC);
                $puElec = $compteur['Pu'];
                $codeCli = $compteur['CodeCli'];
            } 
            if(!empty($compteurEau)){
                $stmt = $db->prepare("SELECT CodeCli, Pu FROM  compteur WHERE CodeCompteur = ? AND TypeCompteur='EAU'");
                $stmt->execute([$compteurEau]);
                $compteur = $stmt->fetch(PDO::FETCH_ASSOC);
                $puEau = $compteur['Pu'];
                $codeCli = $compteur['CodeCli'];
            } 
            
            $stmt = $db->prepare('INSERT INTO payer(Idpaye,CodeCli,Montant,CodeReleve) VALUES (?,?,?,?)');
            $idpaye = 'Fac'.$codeReleve;
            $montant = ($valeurEau * $puEau) + ($valeurElec * $puElec);
            $stmt->execute([$idpaye, $codeCli, $montant, $codeReleve]);
        }
    }
    //Toujours rediriger vers la page Liste des relevés
    header('location:../releves.php');
    die();
?>