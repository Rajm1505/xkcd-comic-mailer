<?php
session_start();
include "connection.php";
require "./verification.php";

$email = isset($_GET["email"])?$_GET["email"]:"";
$btn_subscribe =  isset($_GET['BtnSubscribe'])?$_GET['BtnSubscribe']:"";
$code = isset($_GET['code'])?$_GET['code']:"";


//check if email is already subscribed
if(isSubscribed($email)){
    $_SESSION["errormessage"] = "You are Already Subscribed";
    header("location:index.php"); 
    exit();
} 

if($btn_subscribe){ //if subscribed button is clicked
    sendVerificationCode($email, $for_sub=1);
}
if($code){
    $verified_email = verifyCode($code,$for_sub = 1);

    if($verified_email){
        $jobid = createCronjob($verified_email);
        $sql = sprintf("update subscription set is_active = 1, jobid = %u  where verification_code = '%s'",$jobid,$code);
        $conn->query($sql);

        $_SESSION["successmessage"] = "Subscribed Successfully";
        header("location:index.php");
        exit();
    }else{
        $_SESSION["errormessage"] = "Invalid Code";
        header("location:index.php"); 
        exit();
    }    
}

function createCronjob($email){
    global $email;
        $data = array(
            "job"=>array(
                "title" => $email,
                "url" => $_SERVER["HTTP_HOST"]."/rtCamp-Assignment-Practice/sendmail.php?email=".$email,
                "enabled"=> true,
                'saveResponses' => true,
                "schedule"=>array(
                    "timezone"=>"Asia/Kolkata",
                    "hours"=>[-1],
                    "mdays"=>[-1],
                    "minutes"=>range(0, 59, 5),
                    "months"=>[-1],
                    "wdays"=>[-1]
                )
            )
                );
         
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer Pn7R1+JePLlQqt/7Z/b4H1M/TXjxm9G/puNVNvQQ+Mk="
        );
      
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,'https://api.cron-job.org/jobs');
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
    
        $response = curl_exec($curl);
        
        if($error = curl_error($curl)){
            echo $error;
            exit;
        }
        else{
            $response = json_decode($response,true);
        }  
        curl_close($curl);
        return $response["jobId"];
    }

?>