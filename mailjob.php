<?php
session_start();
include "connection.php";

$email = $_GET["email"];
$subscribe =  isset($_GET['BtnSubscribe'])?$_GET['BtnSubscribe']:"";

echo $email;

function addSubscriptionDB($jobid){
    global $email,$conn;
    $sql= sprintf("select id from subscription where email = '%s' and is_active=0",$email);
    echo "sql1", $sql;
    $result = $conn->query($sql);
    if($result->num_rows){
        $sql = sprintf("update subscription set is_active = 1 and jobid = %u where email = '%s'",$jobid,$email);
        $conn->query($sql);
    }
    else{
        $sql = sprintf("insert into subscription(email,jobid,is_active) values('%s',%u,1)",$email,$jobid);
        $conn->query($sql);
    }
}

function isSubscribed(){
    global $conn,$email,$subscribe;
    $sql = sprintf("select jobid from subscription where email = '%s' and is_active = 1",$email);
    $result = $conn->query($sql);
    if($result->num_rows){
        $_SESSION["message"] = "You are Already Subscribed";
        header("location:index.php");  
    }
    
}

if ($subscribe){
    
    isSubscribed();
    $data = array(
        "job"=>array(
            "url" => "localhost/rtCamp-Assignment-Practice/mailjob.php?email=".$email,
            "enabled"=> true,
            'saveResponses' => true,
            "schedule"=>array(
                "timezone"=>"Asia/Kolkata",
                "hours"=>[-1],
                "mdays"=>[-1],
                "minutes"=>[5],
                "months"=>[-1],
                "wdays"=>[-1]
            )
        )
    );
     
    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer Pn7R1+JePLlQqt/7Z/b4H1M/TXjxm9G/puNVNvQQ+Mk="
    );

    print_r($headers);
    echo "<pre>";
    print_r($data);
    echo "</pre>";

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
        print_r($response);
        addSubscriptionDB($response["jobId"]);
        echo"Job Created Successfully";
    }  
    curl_close($curl);
}

function sendmail(){
    global $email;
    $result = mail($email,"Comic Assignment Test","This is a message for comic assignment");
    echo $result?"Sent Success": "Error";
}

?>