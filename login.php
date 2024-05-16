<?php
session_start();
unset($_SESSION["email"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSA Market | Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
</head>

<body>
    <header>
        <img src="images/logo.jpg" onclick="changePage('index.php')">
        <div class="div-header">
            <h1> RSA Market </h1>
            <p> Tutto quello che vuoi, proponendo il prezzo! </p>
        </div>
        <img src="images/logo.jpg" onclick="changePage('index.php')">    
    </header>

    <div id="login-form">
        <h3 class="h3-title"> Per accedere a tutti i tuoi privilegi effettua il Login. </h3>
        
        <form action="accounthandler.php" method="post" class="form">
            <div class="div-label">
                <p> E-mail/Username </p>
                <input type="text" name="userinfo" id="userid" placeholder="example@domain.com">
            </div>
            <div class="div-label">
                <p> Password </p>
                <input type="password" name="password" id="password" required>
            </div>
            
            <input style="display: none" type="text" name="method" value="login">
            <button type="submit"> Accedi </button>
        </form>

        <?php
            $emessage = !isset($_SESSION["login_error"]) || empty($_SESSION["login_error"]) ? "" : "
                <br><p class='errors'>{$_SESSION['login_error']}</p>";
            echo $emessage;
        ?>
    </div>

    <div class="div-links">
        <a href="register.php"> Non hai un account? </a>
        |
        <a href="account.php"> Non ricordi la password? </a>
    </div>

    <footer>
        
    </footer>
</body>

</html>