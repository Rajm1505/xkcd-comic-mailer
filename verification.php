<?php
include "./connection.php";

function isSubscribed($email){
    global $conn;

    $sql = sprintf("select jobid from subscription where email = '%s' and is_active = 1",$email);
    $result = $conn->query($sql);
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            return $row["jobid"];
        }
    }else{
        return false;
    } 

} 


function generateVerificationCode($email){
    return md5($email.time());
}

//"for_sub" checks if verification code is needed to send of subscription or otherwise.
function sendVerificationCode($email,bool $for_sub){
    global $conn;
    $code = generateVerificationCode($email);

    $headers  = "From: " . "automailclient0@gmail.com" . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if($for_sub){ 
        $body = "<p>Verify your email to Subscribe ComicBot <a href='{$_SERVER['HTTP_HOST']}/subscribe.php?code={$code}'>Click here</a></p>";
    }
    else{
        $body = "<p>Verify your email to Unsubscribe ComicBot <a href='{$_SERVER['HTTP_HOST']}/unsubscribe.php?code={$code}'>Click here</a></p>";
    }
    
    $mail = mail($email,"Verify your email",$body,$headers);
    if($mail){
        $sql= sprintf("select id from subscription where email = '%s'",$email);
        $result = $conn->query($sql);
        if($result->num_rows){
            $sql = sprintf("update subscription set verification_code = '%s'  where email = '%s'",$code,$email);
            $conn->query($sql);
        }
        else{
            $sql = sprintf("insert into subscription(email,verification_code) values('%s','%s')",$email,$code); 
            $result = $conn->query($sql);
        }
        echo "Check your email for verfication mail";      
    }   
}


function verifyCode($code,bool $for_sub){
    global $conn;
    
    $sql = sprintf("select email,jobid from subscription where verification_code = '%s'",$code);
    $result = $conn->query($sql);

    if($result->num_rows){
        while($row = $result->fetch_assoc()){
            return $for_sub? $row["email"]:$row["jobid"];
        }
    }else{
        return false;
    }
}

?>