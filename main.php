<?php

if(isset($_POST["request"])) {
    
    #   Bei Anfragetyp 0 (Datenbankeinträge auslesen)
    #
    if ($_POST["request"] === "1") 
    {
       echo "ok"; 
    }
} else {
    echo "ERROR!";
}

?>