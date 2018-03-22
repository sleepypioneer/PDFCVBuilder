<?php

require("fpdf/fpdf.php");

/* ************************

    Extends FPDF Class

************************* */

class PDF extends FPDF
{
    
function setFooterDetails($footerDetails)
{
    $this->footerDetails = $footerDetails;
}

function Footer()
{
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print centered short details
    $this->Cell(0,10, $this->footerDetails." | Page ".$this->PageNo(),0,0,'C');
}

    
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

function vcell($c_width,$c_height,$x_axis,$text)
{
    $w_w=$c_height/3;
    $w_w_1=$w_w+2;
    $w_w1=$w_w+$w_w+$w_w+3;
    $len=strlen($text);                                                                // check the length of the cell and splits the text into 12 character each and saves in a array 
    if($len>12){
        $w_text=str_split($text,12);
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w_1,$w_text[0],'','','');
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w1,$w_text[1],'','','');
        $this->SetX($x_axis);
        $this->Cell($c_width,$c_height,'','LTRB',0,'L',0);
    }
    else{
        $this->SetX($x_axis);
        $this->Cell($c_width,$c_height,$text,'LTRB',0,'L',0);
    }
}
}

$pdf = new PDF();
$width = $pdf->GetPageWidth();
$pdf->SetAutoPageBreak(true, 2);                                                        // Set auto page breaks
                                                                                        // Checks if data has been sent, if not returns error

if(isset($_POST["data"])) {
    $pdf->SetFont("Helvetica", "B", 32);                                                // Set up Font, size and styling
    $pdf->SetTextColor(0,0,0);                                                          // Set up Text Color
    $pdf->AddPage();                                                                    // Create Page
    
                                                                                        // Check for file upload Errors
    if(isset($_FILES["error"]) && $_FILES["error"] != 0) {
        echo "ERROR";
    }
    
    /* ******************
    
        Profile Photo
        
    ******************* */
    if(isset($_FILES["photograph"]['name']))
    {
        
        print_r($_FILES['photograph']);
        move_uploaded_file($_FILES['photograph']['tmp_name'], "imgs/".$_FILES["photograph"]['name']);   // Upload photo and save it into Imgs folder
    
        $profileImage = "imgs/".$_FILES['photograph']['name'];                          // Set profile image to file uploaded
        $x_axis = ($width / 2) - 20;                                                    // work out mid point for image (page_width/ 2 minus half image_width )
        $pdf->Image($profileImage,$x_axis,10,40,0);                                     // Takes Image file and embeds it into the PDF
        $pdf->SetY(45);                                                                 // Set Y point now to below image for next section
        $pdf->Line(10,100,$width-10, 100);                                              // Dividing Line (Deco only) this setting is for if a photo has been given
    } else {
        $pdf->Line(10,65,$width-10, 65);                                                // Dividing Line (Deco only) - when no photo uploaded
    }
    
    $CV = json_decode($_POST["data"], true);                                            // Decode the data sent as JSON
    $email = $CV['email'];                                                              // Set email value
    $name = $CV['firstname']." ".$CV['lastname'];                                       // Name Section
    $pdf->MultiCell(0, 32, $name, 0, 'C', false);
    $pdf->SetFontSize(12);
    $summaryInfoLine1 = "DOB: ".$CV['dob']." | Nationality: ".$CV['nationality'];       // Set Personal details
    $pdf->MultiCell(0, 12, $summaryInfoLine1, 0, 'C', false);
    $summaryInfoLine2 = $CV['address']['houseNo']." ".$CV['address']['street']." | ".$CV['address']['postcode']." ".$CV['address']['city']." | ".$CV['tel']." | ".$CV['liscence']['issuer']." Driving Liscence, type: ".$CV['liscence']['type'];
    $pdf->MultiCell(0, 12, $summaryInfoLine2, 0, 'C', false);                           // Set Contact details
    $pdf->Ln();
    
    $starting_y = $pdf->gety();
 
    /* *********************
    
        Professional Exp
        
    *********************** */
    $pdf->SetFontSize(10);
    $pdf->Write(6,"Professional Experience:");
    $pdf->Ln();
    
    $education = $CV['professionExp'];
    $pdf->SetFontSize(10);
    $header = array('Start', 'End', 'Company', 'Position');                             // Column headings
    $c_width = array(15, 15, 25, 25);                                                   // Cell width 
    $c_height=10;                                                                       // Cell height
    
    for($i=0;$i<count($header);$i++)                                                    // Header for table
        $pdf->Cell($c_width[$i],7,$header[$i],1,0,'C');
        $pdf->Ln();
    
    foreach($education as $row)
    {
        print_r($row);
        $x_axis=$pdf->getx();                                                           // Get x location
        $content = $row['startDate'];                                                   // Set content 
        $pdf->vcell($c_width[0],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['endDate'];                                                     // Set new content
        $pdf->vcell($c_width[1],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['company'];                                                     // Set new content
        $pdf->vcell($c_width[2],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['position'];                                                    // Set new content
        $pdf->vcell($c_width[3],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $pdf->Ln();
    }
    
    $pdf->Ln();

    /* *********************
    
        Qualifications 
        
    *********************** */
    $pdf->SetFontSize(10);
    $pdf->Write(6,"Qualifications:");
    $pdf->Ln();
    
    $education = $CV['education'];
    $pdf->SetFontSize(10);
    $header = array('Start', 'End', 'Qualification', 'Insititute', 'Grade');            // Column headings
    $c_width = array(15, 15, 25, 25, 15);                                               // Cell width 
    $c_height=10;                                                                       // Cell height
    
    for($i=0;$i<count($header);$i++)                                                    // Header for table
        $pdf->Cell($c_width[$i],7,$header[$i],1,0,'C');
        $pdf->Ln();
    
    foreach($education as $row)
    {
        print_r($row);
        $x_axis=$pdf->getx();                                                           // Get x location
        $content = $row['startDate'];                                                   // Set content 
        $pdf->vcell($c_width[0],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['endDate'];                                                     // Set new content
        $pdf->vcell($c_width[1],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['qualification'];                                               // Set new content
        $pdf->vcell($c_width[2],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['institute'];                                                   // Set new content
        $pdf->vcell($c_width[3],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['grade'];                                                       // Set new content
        $pdf->vcell($c_width[4],$c_height,$x_axis,$content);                            // Write cell 
        $pdf->Ln();
    }
    
    
     /* *********************
    
        Summary Section
        
    *********************** */
    $summaryText = $CV['summary'];
    $pdf->SetXY(100,$starting_y);
    $pdf->MultiCell($width/ 2, 12, $summaryText, 0, 'C', false);
    
    
    $end_of_summary = $pdf->gety();                                                     // Get Y point after this section so able to set next section start point with it

    /* *********************
    
        Computer skills
        
    *********************** */
    $pdf->SetXY(120,$end_of_summary+10);
    $pdf->Write(6,"Computer Programmes:");
    $pdf->Ln();
    $c_width = array(30, 40);    
    $programmes = $CV['programmes'];                                                    // Extract Programmes Array
    foreach($programmes as $row)
    {
        print_r($row);
        $x_axis=120;                                                                    // Get x location
        $content = $row['programme'];                                                   // Set content 
        $pdf->vcell($c_width[0],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['skillLevel'];                                                  // Set new content
        $pdf->vcell($c_width[1],$c_height,$x_axis,$content);                            // Write cell 

        $pdf->Ln();
    }
    
    $end_of_summary = $pdf->gety();                                                     // Get Y point after this section so able to set next section start point with it
 
    /* *********************
    
        Language Skills
        
    *********************** */
    $pdf->SetXY(120,$end_of_summary+10);
    $pdf->Write(6,"Languages:");
    $pdf->Ln();
    $languages = $CV['languages'];                                                    // Extract Programmes Array
    foreach($languages as $row)
    {
        print_r($row);
        $x_axis=120;                                                                    // Get x location
        $content = $row['Language'];                                                   // Set content 
        $pdf->vcell($c_width[0],$c_height,$x_axis,$content);                            // Write cell 
        $x_axis=$pdf->getx();                                                           // now get current pdf x axis value
        $content = $row['skillLevel'];                                                  // Set new content
        $pdf->vcell($c_width[1],$c_height,$x_axis,$content);                            // Write cell 

        $pdf->Ln();
    }
    

    /* *********************
    
            Footer
        
    *********************** */
    $footerDetails = $name." | ".$email;
    $pdf->setFooterDetails($footerDetails);


    $pdf->Output("pdf_test.pdf","F");
    print_r($education);
} else {
    echo "ERROR!";
}

?>