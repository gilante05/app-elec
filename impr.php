<?php
        require('includes/connexion.php');
        $db = connect_bd();

        $sql = "SELECT c.CodeCli, c.Nom, c.Prenom, c.Quartier, p.Date_paiement,
        r.CodeReleve, r.CompteurElec, r.ValeurElec, r.CompteurEau, r.ValeurEau, r.Date_releve,
        r.Date_presentation, r.Date_limite_paiement
        FROM client c, payer p, releve r 
        WHERE (c.CodeCli = p.CodeCli AND p.CodeReleve = r.CodeReleve AND p.Idpaye = '2025-04-09' AND MONTH(`Date_paiement`)=4)";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $facture = $stmt->fetch(PDO::FETCH_ASSOC);
        //$mois = (int)date('m', strtotime($mois_fac));
        if($facture){
            $nom = $facture['Nom'];
            $prenom = $facture['Prenom'];
            $datePres = $facture['Date_presentation'];
            $dateLimite = $facture['Date_limite_paiement'];
            $quartier = $facture['Quartier'];
            $cptElec = $facture['CompteurElec'];
            $cptEau = $facture['CompteurEau'];
            $valElec = $facture['ValeurElec'];
            $valEau = $facture['ValeurEau'];
            $dateFacture = $facture['Date_releve'];
            $codeCli = $facture['CodeCli'];
            $mois = (int)date('m', strtotime($dateFacture)) ;
            $puElec =  $puEau = 0;
            if($cptElec){
                $stmtElec = $db->prepare("SELECT Pu FROM `compteur` WHERE `CodeCompteur`= ? AND `TypeCompteur`='ELECTRICITE'");
                $stmtElec->execute([$cptElec]);
                $resPuElec = $stmtElec->fetch(PDO::FETCH_ASSOC);
                $puElec = isset($resPuElec)? $resPuElec['Pu']:0;
            }
            if($cptEau){
                $stmtEau = $db->prepare("SELECT Pu FROM `compteur` WHERE `CodeCompteur`= ? AND `TypeCompteur`='EAU'");
                $stmtEau->execute([$cptEau]);
                $resPuEau = $stmtEau->fetch(PDO::FETCH_ASSOC);
            }

            // Création du PDF
            require_once('pdf.php');
            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);

            // Infos Client
            $pdf->Cell(190, 10, 'Votre facture du mois de : '.$mois, 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(95, 7, 'Titulaire du compte : '.$nom.' '.$prenom, 0, 0);
            $pdf->Cell(95, 7, 'Date de présentation : '.$datePres, 0, 1);
            $pdf->Cell(95, 7, 'Référence Client : '.$codeCli, 0, 0);
            $pdf->Cell(95, 7, 'Date limite paiement : '.$dateLimite, 0, 1);
            $pdf->Cell(95, 7, 'Adresse installation : '.$quartier, 0, 1);
            $pdf->Cell(95, 7, 'N° compteur électricité : '.$cptElec, 0, 1);
            $pdf->Cell(95, 7, 'N° compteur eau : '.$cptEau, 0, 1);
            $pdf->Ln(5);

            // Tableau Facture
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(63, 7, ' ', 1, 0, 'C');
            $pdf->Cell(63, 7, 'Electricité', 1, 0, 'C');
            $pdf->Cell(63, 7, 'Eau', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(63, 7, 'PU (Ar)', 1, 0, 'C');
            $pdf->Cell(63, 7, $puElec, 1, 0, 'C');
            $pdf->Cell(63, 7, $puEau, 1, 1, 'C');

            $pdf->Cell(63, 7, 'Valeur', 1, 0, 'C');
            $pdf->Cell(63, 7, $valElec, 1, 0, 'C');
            $pdf->Cell(63, 7, $valEau, 1, 1, 'C');

            $pdf->Cell(63, 7, 'Total (Ar)', 1, 0, 'C');
            $pdf->Cell(63, 7, $puElec * $valElec, 1, 0, 'C');
            $pdf->Cell(63, 7, $puEau * $valEau, 1, 1, 'C');
            $montant = ($puElec * $valElec) + ($puEau * $valEau);
            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(190, 10, 'NET A PAYER :'. $montant.' Ariary', 0, 1, 'R');

            $pdf->Output('facture'.$codeCli.'-'.$dateFacture.'.pdf', 'I'); // Affiche directement le PDF dans le navigateur
            die();
        }
?>