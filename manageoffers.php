<?php
session_start();
include_once("connectdb.php");
include_once("credentialscheck.php");
$conn = getConn();
checkSessionCredentials($conn);

$redpage = "mysales.php";
$email = $_SESSION["email"];

$saleid = $_POST["saleid"];

if(!isset($saleid) || !isValid( $saleid ) || !is_numeric($saleid) ){
    redirect($redpage);
}

$sql = "SELECT nome FROM Annunci
        WHERE id = $saleid
        AND user_email = '$email'";

$result = $conn->query($sql);

if(!($result->num_rows > 0)){
    redirect($redpage);
}

$title = $result->fetch_assoc()["nome"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSAMarket | Vedi Proposte</title>
</head>
<body>
    <?php
        echo "<h1>OFFERTE PER $title</h1>";
        $sql = "SELECT Proposte.id,Proposte.valore,Proposte.time,Proposte.stato,Users.username,Users.fotoProfilo
                FROM Proposte
                JOIN Users on Users.email = Proposte.user_email
                WHERE Proposte.annuncio_id = $saleid
                AND Proposte.stato != 'deleted'
                ORDER BY Proposte.time DESC";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $offerid = $row["id"];
                $sum = $row["valore"];
                $time = $row["time"];
                $state = $row["stato"];
                $authorprofileimg = array_key_exists("fotoProfilo",$row) && isValid($row["fotoProfilo"]) ? $row["fotoProfilo"] : "./images/defaultprofileimage.png";
                $authorusername = $row["username"];

                echo "Somma: $sum <br>
                    Utente: $authorusername <img src='$authorprofileimg' style='height:30px; width=30px; border-radius: 15px' id='foto_autore'> <br>
                    Stato: $state <br>
                    Data: $time <br>";
                if($state == "available"){
                    echo "
                    <form action='offermanager.php' method='post'>
                    <input type='hidden' name='method' value='accept'>
                    <input type='hidden' name='offerid' value='$offerid'>
                    <input type='hidden' name='saleid' value='$saleid'>
                    <input type='submit' value='Accetta'>
                    </form>
                    ";
                }    
            }
        } else {
            echo "non ci sono ancora proposte per questo annuncio";
        }
    ?>
</body>
</html>