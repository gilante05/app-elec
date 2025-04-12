<?php
    $code_cli = $_POST['code_cli'];
    $mois_fac = $_POST['mois_fact'];
    
    require('includes/connexion.php');
    $db = connect_bd();

    $sql_elec = "SELECT * FROM `facture` WHERE `CodeCli`= ? AND `TypeCompteur`='ELECTRICITE' AND MONTH(`Date_releve`) = ?";
    $sql_eau = "SELECT * FROM `facture` WHERE `CodeCli`= ? AND `TypeCompteur`='EAU' AND MONTH(`Date_releve`) = ?";
    $stmt_elec = $db->prepare($sql_elec);
    $stmt_eau = $db->prepare($sql_eau);
    $mois = (int)date('m', strtotime($mois_fac));
    $stmt_elec->execute([$code_cli, $mois]);
    $stmt_eau->execute([$code_cli,$mois]);

    $fac_elec = $stmt_elec->fetch(PDO::FETCH_ASSOC);
    $fac_eau = $stmt_eau->fetch(PDO::FETCH_ASSOC);

    $nom = ($fac_elec)? $fac_elec['Nom']:'';
    $prenom = ($fac_elec)? $fac_elec['Prenom']:'';
    $date_pr = ($fac_elec)?$fac_elec['Date_presentation']:'';
    $date_lim = ($fac_elec)?$fac_elec['Date_limite_paiement']:'';
    $quartier = ($fac_elec)?$fac_elec['Quartier']:'';
    $cpt_elec = ($fac_elec)?$fac_elec['CodeCompteur']:'';
    $pu_elec = ($fac_elec)?$fac_elec['Pu']:0;
    $val_elec = ($fac_elec)?$fac_elec['Valeur']:0;

    $cpt_eau = ($fac_eau)?$fac_eau['CodeCompteur']:'';
    $pu_eau = ($fac_eau)?$fac_eau['Pu']:0;
    $val_eau = ($fac_eau)?$fac_eau['Valeur']:0;
    

    

    /*echo "Ref client: ".$code_cli . '<br>';
    echo "Mois Fact: ".(int)date('m', strtotime($mois_fac)) . '<br>';*/
    // Création du PDF
    require_once('pdf.php');
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Infos Client
    $pdf->Cell(190, 10, 'Votre facture du mois de : '.$mois_fac, 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 7, 'Titulaire du compte : '.$nom.' '.$prenom, 0, 0);
    $pdf->Cell(95, 7, 'Date de présentation : '.$date_pr, 0, 1);
    $pdf->Cell(95, 7, 'Référence Client : '.$code_cli, 0, 0);
    $pdf->Cell(95, 7, 'Date limite paiement : '.$date_lim, 0, 1);
    $pdf->Cell(95, 7, 'Adresse installation : '.$quartier, 0, 1);
    $pdf->Cell(95, 7, 'N° compteur électricité : '.$cpt_elec, 0, 1);
    $pdf->Cell(95, 7, 'N° compteur eau : '.$cpt_eau, 0, 1);
    $pdf->Ln(5);

    // Tableau Facture
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(63, 7, ' ', 1, 0, 'C');
    $pdf->Cell(63, 7, 'Electricité', 1, 0, 'C');
    $pdf->Cell(63, 7, 'Eau', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(63, 7, 'PU (Ar)', 1, 0, 'C');
    $pdf->Cell(63, 7, $pu_elec, 1, 0, 'C');
    $pdf->Cell(63, 7, $pu_eau, 1, 1, 'C');

    $pdf->Cell(63, 7, 'Valeur', 1, 0, 'C');
    $pdf->Cell(63, 7, $val_elec, 1, 0, 'C');
    $pdf->Cell(63, 7, $val_eau, 1, 1, 'C');

    $pdf->Cell(63, 7, 'Total (Ar)', 1, 0, 'C');
    $pdf->Cell(63, 7, $pu_elec*$val_elec, 1, 0, 'C');
    $pdf->Cell(63, 7, $pu_eau*$val_eau, 1, 1, 'C');

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(190, 10, 'NET A PAYER :'. ($pu_elec*$val_elec)+ ($pu_eau*$val_eau).' Ariary', 0, 1, 'R');

    $pdf->Output('facture.pdf', 'I'); // Affiche directement le PDF dans le navigateur
?>
