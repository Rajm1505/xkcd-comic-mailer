<?php
session_start();
include "connection.php";
$email = $_GET["email"];
$unsubscribe =  isset($_GET['BtnUnsubscribe'])?$_GET['BtnUnsubscribe']:"";



function isSubscribed(){
    global $conn,$email;
    $sql = sprintf("select jobid from subscription where email = '%s' and is_active = 1",$email);
    echo $sql;
    $result = $conn->query($sql);
    if($row = $result->fetch_assoc()){
        return $row["jobid"];
    }
    else{
        $_SESSION['errormessage'] = "You are not Subscribed";
        header("location:index.php");
        exit();
    }      
}

function deleteSubscriptionDB(){
    global $conn,$email;
    $sql = sprintf("update subscription set is_active = 0 where email = '%s'",$email);
    echo $sql;
    $result = $conn->query($sql);
    echo $result;
    // if($result){
        
    //     $_SESSION['msg'] = "Unsubscribed Successfully";
    //     header("location:index.php");
    // }
       
}
if($unsubscribe){
    $jobid = isSubscribed();
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer Pn7R1+JePLlQqt/7Z/b4H1M/TXjxm9G/puNVNvQQ+Mk="
        );
        
        print_r($headers);
        echo $jobid; 
        
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,'https://api.cron-job.org/jobs/'.$jobid);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'DELETE');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
        
        $response = curl_exec($curl);
        
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