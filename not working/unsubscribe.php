<?php
session_start();
include "connection.php";
$email = $_GET["email"];



function isSubscribed(){
    global $conn,$email;
    $sql = sprintf("select jobid from subscription where email = '%s' and is_active = 1",$email);
    echo $sql;
    $result = $conn->query($sql);
    if($row = $result->fetch_assoc()){
        $GLOBALS["jobid"] = $row["jobid"];
    }
    else{
        $_SESSION['msg'] = "You are not Subscribed";
        header("location:index.php");
    }      
}

function deleteSubscriptionDB(){
    global $conn,$email;
    $sql = sprintf("update subscription set is_active = 0 where email = '%s'",$email);
    echo $sql;
    $result = $conn->query($sql);
    if($result){
        $_SESSION['msg'] = "Unsubscribed Successfully";
        header("location:index.php");
    }
       
}

$headers = array(
    "Content-Type: application/json",
    "Authorization: Bearer Pn7R1+JePLlQqt/7Z/b4H1M/TXjxm9G/puNVNvQQ+Mk="
);

print_r($headers);
echo "<pre>";
echo $GLOBALS["jobid"];

$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,'https://api.cron-job.org/jobs/'.$GLOBALS["jobid"]);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'DELETE');
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);

$response = curl_exec($curl);

if($error = curl_errno($curl)){
    echo $error;
}
else{
    deleteSubscriptionDB();
    echo"Unsubcribed Successfully";
}  


?>