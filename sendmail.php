<?php



function sendmail($email){
    $result = mail($email,"Comic Assignment Test","This is a message for comic assignment");
    
    echo $result?"Sent Success": "Error";
}


?>