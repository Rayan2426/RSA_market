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
    <title>Document</title>
</head>
<body>
    <?php
        $email = $_SESSION["email"];
        $sql = "select Proposte.valore,Proposte.time,Proposte.stato, Annunci.id, Annunci.nome
                FROM Proposte
                JOIN Annunci ON Annunci.id = Proposte.annuncio_id
                ORDER BY Proposte.time DESC";
        $results = $conn->query($sql);
        if($results->num_rows > 0){
            while (($row = $results->fetch_assoc()) != null) {
                $sum = $row["valore"];
                $time = $row["time"];
                $state = $row["stato"];
                $salename = $row["nome"];
                $saleid = $row["id"];
                echo "<div>
                    Valore: $sum <br>
                    Annuncio:<a href='./showsale.php?id=$saleid'> $salename </a><br>
                    Stato: $state <br>
                    Data effettuazione proposta: $time <br>
                    </div>";
            }
        } else{
            echo "non hai ancora fatto nessuna proposta {$conn->error}";
        }
    ?>
</body>
</html>