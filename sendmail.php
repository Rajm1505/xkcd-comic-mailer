<?php
$email = isset($_GET["email"])?$_GET["email"]:"";

if(!$email){
    echo "Email is required";
}



function sendmail($title,$imgurl,$imgalt){
    global $email;
    
    //Defining HTML Content
    $mailcontent = file_get_contents("mailcontent.html"); 

    $htmlcontent = str_replace("&title&",$title,$mailcontent);
    $htmlcontent = str_replace("&imgurl&",$imgurl,$htmlcontent);
    $htmlcontent = str_replace("&imgalt&",$imgalt,$htmlcontent);
    $htmlcontent = str_replace("&unsublink&","//".$_SERVER["HTTP_HOST"]."/rtCamp-Assignment-Practice/unsubscribe.php?frommail=1&email=".$email,$htmlcontent);

    //Get the image data from link
    $imgdata = file_get_contents($imgurl);
    
    //Get image extension
    $imgext = explode('.',$imgurl);
    $imgext = $imgext[count($imgext)-1];

    $mime_boundary = md5(time());

    $headers = "From: automailclient0@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"{$mime_boundary}\"\r\n";

    //Defining attachment 
    $attachment = "--{$mime_boundary}\r\n";
    $attachment .= "Content-Type: image/{$imgext}; name=\"{$title}.{$imgext}\"\r\n";;
    $attachment .= "Content-Disposition: attachment; filename=\"{$title}.{$imgext}\"\r\n";
    $attachment .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $attachment .= chunk_split(base64_encode($imgdata)) . "\r\n";

    //Combining htmlcontent and attachment in the body
    $body =  "--{$mime_boundary}\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
    $body .= $htmlcontent . "\r\n";
    $body .= $attachment;

    $body .= "--{$mime_boundary}--";

    $result = mail($email,"Your random comic is here",$body,$headers);
    
    return $result;
}

function generateRandomComic(){
    
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,"https://c.xkcd.com/random/comic/");
    curl_setopt($curl,CURLOPT_HEADER,true);
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_exec($curl);
    if($error = curl_error($curl)){
        echo $error;
    }
    else{
        $final_url = curl_getinfo($curl,CURLINFO_EFFECTIVE_URL);

        // echo "url: ",$final_url,"</br>";
        $comic = json_decode(file_get_contents($final_url.'info.0.json'),true);

        $result = sendmail($comic['title'],$comic['img'],$comic['alt']);
        echo $result;
    }
}

generateRandomComic();
// sendmail($email,"Faculty:Student Ratio","https://imgs.xkcd.com/comics/faculty_student_ratio.png","Faculty:Student Ratio");



?>