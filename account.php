<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Index</title>
</head>

<body>
    <?php
        include_once("./connectdb.php");
        include_once("./credentialscheck.php");
        $conn = getConn();
        $username = checkSessionCredentials($conn);
        include("./navbar.php");
    ?>
    </div>

    <div id="insert-form">
        <div>
            <form action="process.php" method="post">
                <h3> Compila questo semplice form per cambiare password. </h3>
                <?php
                $sql = "select email,username,nome,cognome from utente where username = '$username'";

                $result = $conn->query($sql);

                $data = $result->fetch_assoc();

                $email = $data["email"];
                $username = $data["username"];
                $nome = $data["nome"];
                $cognome = $data["cognome"];

                $form = "<label for='email'>Email</label>
                            <input type='text' name='email' value='$email' id='email'>
                            <label for='username'>Username</label>
                            <input type='text' name='username' value='$username' id='username'>
                            <label for='nome'>Nome</label>
                            <input type='text' name='nome' value='$nome' id='nome'>
                            <label for='cognome'>Cognome</label>
                            <input type='text' name='cognome' value='$cognome' id='cognome'>
                            <label for='vecchiapassword'>Vecchia Password</label>
                            <input type='password' name='vecchiapassword' id='vecchiapassword'>
                            <label for='nuovapassword'>Nuova Password</label>
                            <input type='password' name='nuovapassword' id='nuovapassword'>";

                echo $form;
                ?>
                <br>
                <input style="display: none" type="text" name="method" value="changecreds">
                <button class="btn btn-primary" type="submit">Cambia Passwrod</button>
            </form>
        </div>
        <?php
        $emessage = !isset($_SESSION["cred_change_status"]) || empty($_SESSION["cred_change_status"]) ? "" : "
        <p class='text-danger'>{$_SESSION['cred_change_status']}</p>";
        echo $emessage;
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>