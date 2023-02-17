<?php

$conn = new mysqli("localhost","root","","rtcampdb");

if($conn->error){
    die($conn->error);
}
?>