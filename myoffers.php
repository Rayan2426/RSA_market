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
    <title>RSAMarket | Le Mie Offerte</title>
</head>
<body>
    <?php
        $email = $_SESSION["email"];
        $sql = "select Proposte.valore,Proposte.time, Proposte.stato, Annunci.id, Annunci.nome
                FROM Proposte
                JOIN Annunci ON Annunci.id = Proposte.annuncio_id
                ORDER BY Proposte.time DESC";
        $results = $conn->query($sql);
        if($results->num_rows > 0){
            while (($row = $results->fetch_assoc()) != null) {
                $sum = $row["valore"];
                $time = $row["time"];
                $state = $row["stato"];
                $salename = htmlspecialchars(urldecode($row["nome"]));
                $saleid = $row["id"];
                
                echo 
                    "<div class='sale-box'>
                        <p> Valore: $sum </p>
                        <p> Annuncio:<a href='./showsale.php?id=$saleid'> $salename </a> <p>
                        <p> Stato: $state </p>
                        <p> Data effettuazione proposta: $time </p>
                    </div>";
            }
        } else{
            echo "<p class='errors'> non hai ancora fatto nessuna proposta {$conn->error} </p>";
        }
    ?>

    <div class="redirect-div">
        <button onclick="changePage('index.php')">Torna alla Homepage</button>
    </div>

    <script src="js/script.js"></script>
</body>
</html>