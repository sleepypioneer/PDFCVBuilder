<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . 'PHPMailer/');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
        
    $mail = new PHPMailer(true);                                    // Passing `true` enables exceptions
    
    //check for header injections
    function has_header_injection($str) {
        return preg_match( "/[\r\n]/", $str);
    }

    // checks to see if submit button was pressed
    if (isset ($_POST['email'])) {
        $email   = trim($_POST['email']);

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
?>