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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>RSAMarket | Le Mie Offerte</title>
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
        $email = $_SESSION["email"];
        $sql = "select Proposte.valore,Proposte.time, Proposte.stato, Annunci.id, Annunci.nome
                FROM Proposte
                JOIN Annunci ON Annunci.id = Proposte.annuncio_id
                WHERE Proposte.user_email = '$email'
                ORDER BY Proposte.time DESC";
        $results = $conn->query($sql);
        if($results->num_rows > 0){
            while (($row = $results->fetch_assoc()) != null) {
                $sum = $row["valore"];
                $time = $row["time"];
                $state = $row["stato"];
                $salename = htmlspecialchars(urldecode($row["nome"]));
                $saleid = $row["id"];
                
                switch($state){
                    case "available": 
                        $state = "Disponibile";
                        echo 
                            "<div class='sale-box' style='border-color: green;'>
                                <p> Valore: $sum €</p>
                                <p> Annuncio:<a href='./showsale.php?id=$saleid'> $salename </a> <p>
                                <p> Stato: $state </p>
                                <p> Data effettuazione proposta: $time </p>
                            </div>";
                        
                        break;

                    case "waiting":
                        $state = "In attesa";
                        echo 
                            "<div class='sale-box' style='border-color: yellow'>
                                <p> Valore: $sum €</p>
                                <p> Annuncio:<a href='./showsale.php?id=$saleid'> $salename </a> <p>
                                <p> Stato: $state </p>
                                <p> Data effettuazione proposta: $time </p>
                            </div>";

                        break;

                    case "closed":
                        $state = "Non disponibile";
                        echo 
                            "<div class='sale-box' style='border-color: red'>
                                <p> Valore: $sum €</p>
                                <p> Annuncio:<a href='./showsale.php?id=$saleid'> $salename </a> <p>
                                <p> Stato: $state </p>
                                <p> Data effettuazione proposta: $time </p>
                            </div>";

                        break;
                }
            }
        } else{
            echo "<p class='errors'> non hai ancora fatto nessuna proposta {$conn->error} </p>";
        }
    ?>

   

    <script src="js/script.js"></script>
</body>
</html>