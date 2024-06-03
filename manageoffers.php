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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>RSAMarket | Vedi Proposte</title>
</head>
<body>
    <header>
        <img src="images/logo.jpg" onclick="changePage('index.php')">
        <div class="div-header">
            <h1> RSA Market </h1>
            <p> Tutto quello che vuoi, proponendo il prezzo! </p>
        </div>
        <div style="margin-right: 70px; display: flex; align-items: center; justify-content: space-around;">
            <?php
                if(!isset($_SESSION["email"])){
                    echo "<button onclick=changePage('login.php') class='login-button'> Vai al Login </button>";
                }
                else{
                    echo "<div class='user-block' onclick=changePage('account.php')>";
                    $profileimg = $_SESSION['profileimg'] ? $_SESSION['profileimg'] : "./images/defaultprofileimage.png";
                    echo "<img class='profile-img' onclick='showOptions()' src=$profileimg>";
                    echo "<p> {$_SESSION['username']} </p>";
                    echo "</div>";
                }
            ?>

            <i class="bi bi-power logout-icon" onclick="changePage('login.php')"></i>
        </div>
    </header>
    
    <div class="redirect-div">
        <button onclick="changePage('index.php')">Torna alla Homepage</button><br><br>
    </div>

    <?php
        echo "<h1 style='margin: 20px; font-size: 24px; text-align: center;'>OFFERTE PER $title</h1>";
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

                echo "
                    <div class='sale-box'>
                        <p> Somma: $sum € </p>
                        <p> Utente: $authorusername <img src='$authorprofileimg' style='height:30px; width=30px; border-radius: 15px' id='foto_autore'> </p>
                        <p> Stato: $state </p>
                        <p> Data: $time </p>";
                if($state == "available"){
                    echo "
                    <form action='offermanager.php' method='post'>
                    <input type='hidden' name='method' value='accept'>
                    <input type='hidden' name='offerid' value='$offerid'>
                    <input type='hidden' name='saleid' value='$saleid'>
                    <input type='submit' class='redirect-butt' value='Accetta Proposta'>
                    </form>
                    </div>
                    ";
                }    
            }
        } else {
            echo "<p class='errors'> non ci sono ancora proposte per questo annuncio </p>";
        }
    ?>

    <script src="js/script.js"></script>
</body>
</html>