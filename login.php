<?php
session_start();
unset($_SESSION["email"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSAMarket | Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <title>RSA Market | Login</title>
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
    </div>

    <footer>
        <p class="footer-paragraph">RSA Market è offerto da: ©</p>
        <div class="developer-container">
            <div>
                <p>Lorenzo Socci</p>
                <p>Sviluppatore Front-End</p>
                <div class="social-container">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-github"></i>
                    <i class="bi bi-tiktok"></i>
                </div>
            </div>
            <div>
                <p>Anatolie Pavlov</p>
                <p>Project Manager - Sviluppatore Database</p>
                <div class="social-container">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-github"></i>
                    <i class="bi bi-tiktok"></i>
                </div>
            </div>
            <div>
                <p>Rayan Moh'd</p>
                <p>Sviluppatore Back-End</p>
                <div class="social-container">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-github" onclick="changePage('https://github.com/Rayan2426')"></i>
                    <i class="bi bi-tiktok"></i>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>