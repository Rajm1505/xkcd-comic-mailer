<?php
session_start();
include "connection.php";
require "./verification.php";
$email = isset($_GET["email"])?$_GET["email"]:"";

$code = isset($_GET["code"])?$_GET["code"]:"";
$btn_unsubscribe =  isset($_GET['BtnUnsubscribe'])?$_GET['BtnUnsubscribe']:"";



if($btn_unsubscribe){
    if(isSubscribed($email)){
        sendVerificationCode($email,$for_sub=0);
    }
    else{
        $_SESSION["errormessage"] = "You are already not subscribed";
        header("location:index.php");
        exit();
    }
}
if($code){
    $jobid = verifyCode($code,$for_sub = 0);
    if($jobid){
        deleteCronjob($jobid);
    }
}

function deleteSubscriptionDB(){
    global $conn,$code;
    $sql = sprintf("update subscription set is_active = 0 where verification_code = '%s'",$code);   
    return $conn->query($sql);
   
}

function deleteCronjob($jobid){
    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer <Cron bearer token>"
    );
    
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,'https://api.cron-job.org/jobs/'.$jobid);
    curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'DELETE');
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
    
    curl_exec($curl);
    
    if($error = curl_errno($curl)){
        echo $error;
    }
    else{
        deleteSubscriptionDB();
        $_SESSION["successmessage"] = "Unsubscribed Successfully";
        header("location:index.php");  
    }  
}
?>
