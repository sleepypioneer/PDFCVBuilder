<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'PHPMailer/');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require("fpdf/fpdf.php");

if(isset($_POST["request"]) &&  $_POST["request"] == 1) 
{

    /* ************************

        Extends FPDF Class

    ************************* */

    class PDF extends FPDF
    {
        function setFooterDetails($footerDetails)                                         // Inject footer details to $pdf Object
        {
            $this->footerDetails = $footerDetails;
        }

        function Footer()                                                                  // Footer with inserted values
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            // Print centered short details
            $this->Cell(0,10, $this->footerDetails." | Page ".$this->PageNo(),0,0,'C');
        }

        function ImprovedTable($header, $data)                                             // Build table
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

        function vcell($c_width,$c_height,$x_axis,$text)                                   // Make word wrap cells
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

    function checkInputValidty($input, $type) {
        $regexDate = '/^[0-9-.]+$/';
        $regexPhone = '/^[\+]?[(]?[0-9]{3}[)]?[\-\s\.]?[0-9]{3}[\-\s\.]?[0-9]{4,6}$/';
        $regexEmail = '/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/';
        $regexText = '/^[a-zA-ZäÄöÖüÜß\-\_\:\"\!\(\)\'\.\s]+$/';
        $regexCode = '/^[a-zA-Z0-9-.]+$/';
        $output = "";
        $test;
        if ($input !== '') {
            switch($type){
                case "date":
                    $test = preg_match($regexDate, $input,$matches, PREG_OFFSET_CAPTURE, 0);
                    break;
                case "phone":
                    $test =  preg_match($regexPhone, $input,$matches, PREG_OFFSET_CAPTURE, 0);
                    break;
                case "email":
                    $test = preg_match($regexEmail,$input,$matches, PREG_OFFSET_CAPTURE, 0);
                    break;
                case "text":
                    $test = preg_match($regexText,$input,$matches, PREG_OFFSET_CAPTURE, 0);
                    break;  
                case "code":
                    $test = preg_match($regexCode,$input,$matches, PREG_OFFSET_CAPTURE, 0);
                    break; 
            }
            if(count($matches) > 0) {
                $output = $matches[0][0];
            } else {
                $output = "Insertion error";
            }
        }
        return $output;
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

            if($_FILES['photograph']);
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
        $firstName = iconv("UTF-8", "CP1250//TRANSLIT", $CV['firstname']);
        $lastName = iconv("UTF-8", "CP1250//TRANSLIT", $CV['lastname']);

        $email = checkInputValidty($CV['email'], 'email');                                  // Set email value



        $name = checkInputValidty($firstName, 'text')." ".checkInputValidty($lastName, 'text');                                       // Name Section
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


        $pdf->Output("pdf_cv.pdf","F");                                               // Creat output pdf and save it
    } else {
        echo "ERROR!";
    }
} 
else if(isset($_POST["request"]) &&  $_POST["request"] == 2) 
{
    $mail = new PHPMailer(true);                                    // Passing `true` enables exceptions
    
    //check for header injections
    function has_header_injection($str) {
        return preg_match( "/[\r\n]/", $str);
    }

    // checks to see if submit button was pressed
    if (isset($_POST['data'])) {
        $email = trim($_POST['data']);
        $email = str_replace('"',"",$email);
        echo $email;
        //Check to see if $name or $email have header injections
        if(has_header_injection($email)) {
            die(); // If true, kill the script
        }

        try {
            //Server settings
            $mail->isSMTP();                                    // Set mailer to use SMTP
            $mail->SMTPDebug = 2;                               // Enable verbose debug output
            $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
            $mail->Port = 587;                                  // TCP port to connect to
            $mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
            $mail->SMTPAuth = true;                             // Enable SMTP authentication
            $mail->Username = 'onlinegurl@gmail.com';           // SMTP username
            $mail->Password = 'cleosletters1!';                 // SMTP password
            

            //Recipients
            $mail->setFrom('onlinegurl@gmail.com', 'PDF CV BUILDER');
            $mail->addAddress($email);                          // Add a recipient
            //$mail->addReplyTo('info@example.com', 'Information');

            //Attachments
            $mail->addAttachment('pdf_cv.pdf', 'pdfCV.pdf');    // Optional name

            //Content
            $mail->isHTML(true);                                // Set email format to HTML
            $mail->Subject = 'your PDF CV is finished!';
            $mail->Body    = 'Thank you for choosing to make your PDF CV with us we wish you much success in your job hunt! </b>';
            $mail->AltBody = 'Thank you for choosing to make your PDF CV with us we wish you much success in your job hunt!';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    } else {
        echo 'No email given';
    }  
}

?>