<?php
  
ob_end_clean();
require('fpdf/fpdf.php');

// Instantiate and use the FPDF class 
$pdf = new FPDF();

//Add a new page
$pdf->AddPage();

// Set the font for the text
$pdf->SetFont('Arial', 'B', 18);

// Prints a cell with given text 
$pdf->Cell(60,20,'JIRO SY RANO MALAGASY');
$pdf->Cell(20,80,'Votre facture du mois: ');

// return the generated output
$pdf->Output();

?>