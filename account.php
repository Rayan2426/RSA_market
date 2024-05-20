<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>RSAMarket | Recupero Account</title>
</head>

<body>
    <?php
        include_once("./connectdb.php");
        include_once("./credentialscheck.php");
        $conn = getConn();
        checkSessionCredentials($conn);
    ?>

    <header>
        <img src="images/logo.jpg" onclick="changePage('index.php')">
        <div class="div-header">
            <h1> RSA Market </h1>
            <p> Tutto quello che vuoi, proponendo il prezzo! </p>
        </div>
        <img src="images/logo.jpg" onclick="changePage('index.php')">    
    </header>

    <div id="insert-form">
        <div>
            <h3 class="h3-title"> Compila questo semplice form per cambiare password </h3>
            <form action="accounthandler.php" method="post" enctype="multipart/form-data" class="form">
                <?php

                $email = $_SESSION["email"];
                $username = $_SESSION["username"];
                $nome = $_SESSION["nome"];
                $cognome = $_SESSION["cognome"];
                $profileimg = isset($_SESSION["profileimg"]) ? $_SESSION["profileimg"] : "./images/defaultprofileimage.png";
                $form = "   
                    <img id='image' src='$profileimg' class='file-image' onclick='document.getElementById(\"imgInp\").click()'>
                    <input type='file' name='profileimg' id='imgInp' accept='images/*' style='display: none;'>
                    <p style='color: var(--black)'> Cambia immagine profilo </p>
                    <div class='div-label'>
                        <p>Email</p>
                        <input type='text' name='email' value='$email'>
                    </div>
                    <div class='div-label'>
                        <p>Username</p>
                        <input type='text' name='username' value='$username'>
                    </div>
                    <div class='div-label'>
                        <p>Nome</p>
                        <input type='text' name='nome' value='$nome'>
                    </div>
                    <div class='div-label'>
                        <p>Cognome</p>
                        <input type='text' name='cognome' value='$cognome'>
                    </div>
                    <div class='div-label'>
                        <p>Vecchia Password</p>
                        <input type='password' name='vecchiapassword'>
                    </div>
                    <div class='div-label'>
                        <p>Nuova Password</p>
                        <input type='password' name='nuovapassword'>
                    </div>
                ";

                echo $form;
                ?>
                
                <input style="display: none" type="text" name="method" value="changecreds">
                <button type="submit">Aggiorna</button>
            </form>
        </div>
        <?php
            $emessage = !isset($_SESSION["cred_change_status"]) || empty($_SESSION["cred_change_status"]) ? "" : "
            <p class='errors'>{$_SESSION['cred_change_status']}</p>";
            echo $emessage;
        ?>
    </div>

    <script>
        let imgInp = document.getElementById("imgInp");
        imgInp.onchange = evt => {
            const [file] = imgInp.files;
            if (file) {
                let image = document.getElementById("image");
                image.src = URL.createObjectURL(file);
            }
        }
    </script>
</body>

</html>