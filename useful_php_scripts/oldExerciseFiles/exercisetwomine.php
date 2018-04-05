<!--//Questions:



1. Create a file called exercisetwo.php in your working files

2. Read the following sentence carefully

    You got contacted by a senior manager from Virtualines.com and he wants the following to be set up for his company's online backend management system.
    
    He wants to process the following data which comes in via a form on the customerqueries.php (same page as form)
       
        a, username    b. secretword   c. email     d. age   e. fullname   f. address   g. customer complaint
    
    
    i. He wants these data securely collected wants to know which super global variables that you will be using
    
    ii. He wants all the data to be validated and sanitized before they are passed to the processcustomerquery() for processing
    
    iii. He wants to keep the customer username and email throughtout the duration of the application until they sign out to avoid creating more functions that will fetch for the username and email all the time
    
    iv. He wants you to create a fucntion that will verify the minimum secretword lenght (8) before it's passed to a function for processing
    
    v. He wants you to keep all the data coming in from the form in a variable and write a function that will display all the data to the support team on request 
    
Nb. He wants all the functions to display error and success messages containing the values from the form within their respective statement when possible and for now, he wants you to assume or use static values.
-->

<?php

session_start();

//raw variables with static dat

$raw_username = "Heidi";
$raw_secretword = "ilovedogs";
$raw_email = "ilovedogs@gmail.com";
$raw_age = 32;
$raw_fullname = "Heidi James";
$raw_address = "Apple Street 2, Berlin 11091";
$raw_customer_complaint = "I bought a dog collar from your store but it has teared after two weeks and I was refused a refund in your store!";

//raw_var = trim($_POST['inputfield']);

/*
i.
    $_SERVER['PHP_SELF'];
    $_POST;
    $_SERVER[REQUEST_METHOD] "POST";
    
*/

// ii.

$clean_username = filter_var($raw_username, FILTER_SANITIZE_STRING);
$clean_secretword = filter_var($raw_secretword, FILTER_SANITIZE_STRING);
$clean_email = filter_var($raw_email, FILTER_VALIDATE_EMAIL);
$clean_age = filter_var($raw_age, FILTER_VALIDATE_INT);
$clean_fullname = filter_var($raw_fullname, FILTER_SANITIZE_STRING);
$clean_address = filter_var($raw_address, FILTER_SANITIZE_STRING);
$clean_customer_complaint = filter_var($raw_customer_complaint, FILTER_SANITIZE_STRING);

// iii.

$_SESSION['customer_data'] = array(

    'username'      =>  $clean_username,
    'email'         =>  $clean_email

);

// iv.
function minimum_secretword($clean_secretword){
    if (strlen($clean_secretword) < 8 ){
        echo("The secret word you chose:  $clean_secretword is too short");
    }  
}

minimum_secretword($clean_secretword);


// v.
$stored_data = array($clean_username, $clean_secretword, $clean_email, $clean_age, $clean_fullname, $clean_address, $clean_customer_complaint);

function display_all_data($stored_data){
    $data_length = count($stored_data); 
    for($i = 0; $i < $data_length; $i++){
        echo "<li>" . $stored_data[$i] . "</li>";
    }
}

display_all_data($stored_data);

    




























?>