<!--
1. Create a php file called exerciseone.php in your working-files folder

2. Read the following sentense and create about 6 variables (3 strings / 3 int values)

    A user named Kelvin Hart came to Dubai to perform on 4th April 2016. He is like 5 inches tall and I guess he is 30 years old. His show was restricted. users between the ages of 18 - 49 only could attend. users below the 17 were told to wait for their parents outside and users above 50 were asked to wait in the car.   
    
3. Create an associative array of three values for the sentense in question 2 and echo th results
    
    
4. Write one statement for the sentence in question 2 using your variables in question 2, your statement should include the following if, else and elseif 


     
5. echo out the second value in your associative array from question 3 
     



Nb. If you were able to run it without any error. You have successfully understood php basics
-->

<?php

$performer =  "Kelvin Hart";
$reject_young = "wait for you're parents outside.";
$reject_old = "wait in the car";

$user_age = 16;
$lower_age = 17;
$upper_age = 50;

$array = array('performer'=>'Kelvin Hart', 'reject_young'=>'wait for you\'re parents outside.', 'reject_old'=>'wait in the car', 'lower_age'=>17, 'upper_age'=>50);

function allowed_in($user_age, $lower_age, $upper_age, $array) {
    if($user_age <= $lower_age){
        echo "Sorry but you can't come in, please " . $array['reject_young'];
    } else if ($user_age >= $upper_age){
        echo "Sorry but you can't come in, please " . $array['reject_old'];
    } else {
        echo "Come on in! Your going to have a great time at the $performer concert, woop! Woop!";
    }
}


?>

<ul>
    <li><?php print_r($array); ?></li>
    <li><?php 
            echo $array['lower_age'];   
        ?></li>
    <li><?php
            echo $array['upper_age'];
        ?></li>
    <li><?php 
        allowed_in($user_age, $lower_age, $upper_age, $array);
        ?></li>
</ul>
