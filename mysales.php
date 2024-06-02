<?php
session_start();
include_once("connectdb.php");
include_once("credentialscheck.php");
$conn = getConn();
checkSessionCredentials($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>RSAMarket | I Miei Annunci</title>
</head>
<body>
    <?php
        $email = $_SESSION["email"];

        $sql = "SELECT Annunci.id,Annunci.nome, Annunci.stato, Annunci.data FROM Annunci
                WHERE Annunci.user_email = '$email'";

        $results = $conn->query($sql);

        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $id = $row["id"];
                $title = htmlspecialchars(urldecode($row["nome"]));
                $state = $row["stato"];
                $data = $row["data"];
                $num = 0;

                $sql = "SELECT count(*) AS num_proposte FROM Annunci
                JOIN Proposte ON Proposte.annuncio_id = Annunci.id
                WHERE Annunci.id = $id";

                $offers = $conn->query($sql);

                if ($offers->num_rows > 0) {
                    $num = $offers->fetch_assoc()["num_proposte"];
                }

                echo "<div class='sale-box'>
                        <p> ID: $id </p>
                        <p> Annuncio: $title </p>
                        <p> Stato: $state </p>
                        <p> Data di pubblicazione: $data </p>
                        <p> Numero di offerte: $num </p>
                        <form action='manageoffers.php' method='post'>
                            <input type='submit' value='Vedi le Proposte' class='offer-button'>
                            <input type='hidden' name='saleid' value='$id'>
                        </form>
                        <form action='salemanager.php' method='post'>
                            <input type='submit' value='Elimina annuncio' class='delete-button'>
                            <input type='hidden' name='saleid' value='$id'>
                            <input type='hidden' name='method' value='delete'>
                        </form>
                    </div>";
            }
        } else{
            echo "<p class='errors'> Non hai ancora pubblicato annunci {$conn->error} </p>";
        }
    ?>

    <div class="redirect-div">
        <button onclick="changePage('index.php')">Torna alla Homepage</button>
    </div>

    <script src="js/script.js"></script>
</body>
</html>