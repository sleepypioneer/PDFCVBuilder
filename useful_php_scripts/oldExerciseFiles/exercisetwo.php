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

   
   
   
// Solutions: <br><br>

<?php
    
    session_start();

    //Collecting Variables and using static values

    //$raw_username               = trim($_POST['username']);
    
    $raw_username               = "kobbyb";    
    
    $raw_secretword             = "nba";
    
    $raw_email                  = "kbriend@virtualines.com"; 
    
    $raw_age                    = 40;
    
    $raw_fullname               = "Kobby Briend";
    
    $raw_address                = "New York";
    
    $raw_customer_complaint     = "My Credit Card got decline twice today";   
   
   
    //Solution for Question i.

//    $_SERVER[PHP_SELF];
//
//    $_SERVER[REQUEST_METHOD] "POST";
//
//    $_POST;


    //Solution for Question ii.
   
    $c_username               = filter_var($raw_username, FILTER_SANITIZE_STRING);    
    
    $c_secretword             = filter_var($raw_secretword, FILTER_SANITIZE_STRING);
    
    $c_email                  = filter_var($raw_email, FILTER_VALIDATE_EMAIL); 
    
    $c_age                    = filter_var($raw_age, FILTER_VALIDATE_INT);
    
    $c_fullname               = filter_var($raw_fullname, FILTER_SANITIZE_STRING);
    
    $c_address                = filter_var($raw_address, FILTER_SANITIZE_STRING);
    
    $c_customer_complaint     = filter_var($raw_customer_complaint, FILTER_SANITIZE_STRING);  



    //Solution for Question iii.

    $_SESSION['customer_info'] = array(
    
        'username'      =>  $c_username,
        'email'         =>  $c_email
    
    );
   

    echo "Session username is: " . $_SESSION['customer_info']['username'] . "<br> Email is: " .  $_SESSION['customer_info']['email'] ;


    echo "<br><br>";


    //Solution for Question iv.

    function minsecretword($c_secretword){
        
        $counted_secretword = strlen($c_secretword);
        
        if($counted_secretword >= 8){
            
            echo "Your Secret Word is: '" . $c_secretword . "' and it's correct";
            
        }else{
            
            echo "Your Secret Word '" . $c_secretword . "' cannot be less than 8 characters";
        }
        
    }
    
    //Calling our minsecretword function
    minsecretword($c_secretword);


     echo "<br><br>";

    //Solution for Question v.

    $all_customers_data = array(
    
        
    'userName'                  =>  $c_username,             
    
    'secretWord'                =>  $c_secretword,         
    
    'userEmail'                 =>  $c_email,             
    
    'userAge'                   =>  $c_age,                  
    
    'userFullname'              =>  $c_fullname,         
    
    'userAddress'               => $c_address,               
    
    'userComplaint'             => $c_customer_complaint 
        
    );


    function display_all_customers($all_customers_data){
        
        echo "Hi Support Team, This query just came in: <br><br>";
        
        foreach($all_customers_data as $customer_data){
            
            
            
            echo $customer_data . "<br>";
            
        }
        
    }
    
    //Calling our display_all_customers function
    display_all_customers($all_customers_data);


?>
   
   
   
   
    
