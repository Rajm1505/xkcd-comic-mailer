<?php
session_start();
$emsg = isset($_SESSION["errormessage"])?$_SESSION["errormessage"]:"";
$smsg = isset($_SESSION["successmessage"])?$_SESSION["successmessage"]:"";
unset($_SESSION["errormessage"]);
unset($_SESSION["successmessage"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form action="#" method="get" id="subscriptionform">
            <h2>Subscribe to Comics</h2>
            <p id="errormsg"><?= $emsg ?></p>
            <p id="successmsg"><?= $smsg ?></p>
            <p>Comics will be sent to your email every 5 minutes</p>
            <div class="form-control">
                <label for="email">Email:</label>
                <input type="email" required name="email" placeholder="apc@example.com" id="email">
            </div>
            <div id="buttons">
                <button type="submit" formaction="subscribe.php" name="BtnSubscribe" id="BtnSubscribe" value="1">Subscribe</button>
                <button type="submit" formaction="unsubscribe.php" name="BtnUnsubscribe" id="BtnUnsubscribe" value="1">Unsubscribe</button>
            </div>
        </form>
    </div>
</body>
</html>