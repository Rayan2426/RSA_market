<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>RSA Market | Register</title>
</head>

<body>
    <div id="register-form">
        <div>
            <form action="accounthandler.php" method="post">
                <h3 class="pb-2"> Effettua la registrazione a RSA Market compilando questo semplice form. </h3>

                <label for="email"> Inserisci un'E-mail: *</label>
                <input type="email" name="email" id="email" placeholder="example@gmail.com" required> 

                <label for="nome"> Inserisci un Nome: *</label>
                <input type="text" name="nome" id="nome" placeholder="Es. Mario">

                <label for="cognome"> Inserisci un Cognome: *</label>
                <input type="text" name="cognome" id="cognome" placeholder="Es. Rossi" required>

                <label for="username"> Inserisci uno Username: *</label>
                <input type="text" name="username" id="username" placeholder="Es. MarioRossi">

                <label for="password"> Inserisci una Password: *</label>
                <input type="password" name="password" id="password" required>
            
                <input style="display: none;" type="text" name="method" value="register">
                <input type="submit">Registrati</input>
            </form>
            
            <div>
                <a href="login.php"> Hai già un account? </a>
            </div>

            <p> I campi contrassegnati da * sono obbligatori. </p>
        </div>
        <?php
        $emessage = !isset($_SESSION["register_error"]) || empty($_SESSION["register_error"]) ? "" : "
        <p class='text-danger'>{$_SESSION['register_error']}</p>";
        echo $emessage;
        ?>
        <br>
    </div>
</body>

</html>