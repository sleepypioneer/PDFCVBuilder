<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>
<?php
require("fpdf/fpdf.php");

$pdf = new FPDF();
$pdf->AddPage();

/* Einstellung für Überschrift */
$pdf->SetFont("Helvetica", "B", 11);
$pdf->SetLineWidth(0.4);
$pdf->SetDrawColor(255, 0, 255);
$pdf->SetFillColor(192, 192, 192);
$pdf->SetTextColor(255, 0, 0);

/* Überschrift */
$pdf->Cell(30, 10, "Winkel", "LTR", 0, "C", 1);
$pdf->Cell(40, 10, "im Bogenmass", "LTR", 0, "C", 1);
$pdf->Cell(60, 10, "Sinus(Winkel)", "LTR", 0, "C", 1);
$pdf->Ln();

/* Einstellung für Tabelle */
$pdf->SetFont("", "");
$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(0, 0, 0);

/* Tabelle */
for($w=10; $w<=90; $w=$w+10)
{
  /* Zeilen abwechselnd gestalten */
  if($w%20==0)
  {
    $pdf->SetFillColor(0, 0, 255);
    $pdf->SetTextColor(255, 255, 255);
  }
  else
  {
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
  }
    
  /* Werte */
  $wb = $w / 180 * M_PI;
  $pdf->Cell(30, 10, $w, "LR", 0, "C", 1);
  $pdf->Cell(40, 10, number_format($wb,3), "LR", 0, "R", 1);
  $pdf->Cell(60, 10, number_format(sin($wb),3), "LR", 0, "R", 1);
  $pdf->Ln();
}

$pdf->Output("pdf_test.pdf", "F");
?>
</body></html>
