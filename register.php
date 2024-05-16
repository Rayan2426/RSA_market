<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>RSA Market | Registrazione</title>
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

    <div id="register-form">
        <h3 class="h3-title"> Effettua la registrazione a RSA Market compilando questo semplice form. </h3>
        <p style="padding-top: 20px; text-align: center;"> I campi contrassegnati da * sono obbligatori. </p>
        <div>
            <form action="accounthandler.php" method="post" class="form">
                <div class="div-label">
                    <p> Inserisci un'E-mail: *</p>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" required> 
                </div>

                <div class="div-label">
                    <p> Inserisci un Nome: *</p>
                    <input type="text" name="nome" id="nome" placeholder="Es. Mario" required>
                </div>

                <div class="div-label">
                    <p> Inserisci un Cognome: *</p>
                    <input type="text" name="cognome" id="cognome" placeholder="Es. Rossi" required>
                </div>

                <div class="div-label">
                    <p> Inserisci uno Username: *</p>
                    <input type="text" name="username" id="username" placeholder="Es. MarioRossi" required>
                </div>

                <div class="div-label">
                    <p> Inserisci la Data di Nascita: *</p>
                    <input type="date" name="datanascita" id="datanascita" required>
                </div>

                <div class="div-label">
                    <p> Inserisci una Password: *</p>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="div-label">
                    <p> Reinserisci di nuovo la Password: *</p>
                    <input type="password" name="confirmpassword" id="confirmpassword" required>
                </div>
            
                <input style="display: none;" type="text" name="method" value="register">
                <button type="submit">Registrati</button>
            </form>
            
            <div class="div-links">
                <a href="login.php"> Hai già un account? </a>
                |
                <a href="#"> Password dimenticata? </a>
            </div>
        </div>
        <?php
            $emessage = !isset($_SESSION["register_error"]) || empty($_SESSION["register_error"]) ? "" : "
                <p class='errors'>{$_SESSION['register_error']}</p>";
            echo $emessage;
        ?>
    </div>

    <footer>

    </footer>
</body>

</html>