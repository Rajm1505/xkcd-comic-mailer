<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form action="mailjob.php" method="post" id="mailform">
            <h2>Subscribe to Comics</h2>
            <p>Comics will be sent to your email every 5 minutes</p>
            <div class="form-control">
                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="apc@example.com" id="email">
            </div>
            <div><button type="submit" id="BtnSubscribe">Subscribe</button></div>
        </form>
    </div>
</body>
</html>