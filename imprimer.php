<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(190, 10, 'JIRO SY RANO MALAGASY', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Création du PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Infos Client
$pdf->Cell(190, 10, 'Votre facture du mois de : Mai 2024', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(95, 7, 'Titulaire du compte : RAKOTO Bernard', 0, 0);
$pdf->Cell(95, 7, 'Date de présentation : 16/05/2024', 0, 1);
$pdf->Cell(95, 7, 'Référence Client : 10538765', 0, 0);
$pdf->Cell(95, 7, 'Date limite paiement : 25/05/2024', 0, 1);
$pdf->Cell(95, 7, 'Adresse installation : Tanambao', 0, 1);
$pdf->Cell(95, 7, 'N° compteur électricité : C096567889', 0, 1);
$pdf->Cell(95, 7, 'N° compteur eau : E09976585', 0, 1);
$pdf->Ln(5);

// Tableau Facture
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(63, 7, ' ', 1, 0, 'C');
$pdf->Cell(63, 7, 'Electricité', 1, 0, 'C');
$pdf->Cell(63, 7, 'Eau', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(63, 7, 'PU (Ar)', 1, 0, 'C');
$pdf->Cell(63, 7, '340', 1, 0, 'C');
$pdf->Cell(63, 7, '215', 1, 1, 'C');

$pdf->Cell(63, 7, 'Valeur', 1, 0, 'C');
$pdf->Cell(63, 7, '51', 1, 0, 'C');
$pdf->Cell(63, 7, '23', 1, 1, 'C');

$pdf->Cell(63, 7, 'Total (Ar)', 1, 0, 'C');
$pdf->Cell(63, 7, '17.340', 1, 0, 'C');
$pdf->Cell(63, 7, '4.945', 1, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'NET A PAYER : 22.285 Ariary', 0, 1, 'R');

$pdf->Output('facture.pdf', 'I'); // Affiche directement le PDF dans le navigateur
?>