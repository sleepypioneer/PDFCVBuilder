<?php

require("fpdf/fpdf.php");

#$profilePicture = imagecreatefromjpg("profile.jpg");

class PDF extends FPDF
{
// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(15, 15, 25, 25, 15);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],10,$row['startDate'],'LR');
        $this->Cell($w[1],10,$row['endDate'],'LR');
        $this->Cell($w[2],10,$row['qualification'],'LR',0,'R');
        $this->Cell($w[3],10,$row['institute'],'LR',0,'R');
        $this->Cell($w[4],10,$row['grade'],'LR',0,'R');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
$width = $pdf->GetPageWidth();
// Set auto page breaks
$pdf->SetAutoPageBreak(true, 2);
    
if(isset($_POST["data"])) {
    
    $profileImage = $_FILES['photograph']['name'];
                                                                                                // Check for file upload Errors
    if(isset($_FILES["error"]) && $_FILES["error"] != 0) {
        echo "ERROR";
    }
    
    #   Bei Anfragetyp 0 (Datenbankeinträge auslesen)
    #
    if ($_POST["request"] === "1") 
    {
        $CV = json_decode($_POST["data"], true); 
        
        // Set up Font & Text Color
        $pdf->SetFont("Helvetica", "B", 24);
        $pdf->SetTextColor(0,0,0);
        // Create Page
        $pdf->AddPage();
        
        // Profile Photo
        $pdf->Image($profileImage,10,10,-300);
        
        // Name Section & Contact Details
        $name = $CV['firstname']." ".$CV['lastname'];
        $pdf->MultiCell(0, 24, $name, 0, 'C', false);
        $pdf->SetFontSize(12);
        #$pdf->Ln();
        $summaryInfoLine1 = "DOB: ".$CV['dob']." | Nationality: ".$CV['nationality'];
        $pdf->MultiCell(0, 12, $summaryInfoLine1, 0, 'C', false);
        #$pdf->Ln();
        $summaryInfoLine2 = $CV['address']['houseNo']." ".$CV['address']['street']." | ".$CV['address']['postcode']." ".$CV['address']['city']." | ".$CV['tel']." | ".$CV['liscence']['issuer']." Driving Liscence, type: ".$CV['liscence']['type'];
        $pdf->MultiCell(0, 12, $summaryInfoLine2, 0, 'C', false);
        $pdf->Ln();
        // Dividing Line
        $pdf->Line(10,60,$width-10, 60);
        
        // Summary Section
        
        
        
        // Professional Experience
        
        
        
        // Qualifications
        $education = $CV['education'];
        $pdf->SetFontSize(10);
        $header = array('Start', 'End', 'Qualification', 'Insititute', 'Grade');
        $pdf->ImprovedTable($header,$education);
        // Column headings
        
        // Computer Skills
        
        
        
        // Languages
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        $pdf->Output("pdf_test.pdf","F");
        print_r($education);
    }else {
        echo "Picture ERROR!";
    }
} else {
    echo "ERROR!";
}

?>