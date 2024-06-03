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
    <title>RSAMarket | I Miei Annunci</title>
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
        <button onclick="changePage('index.php')">Torna alla Homepage</button>
    </div>
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
                        <p> Numero di offerte: $num </p>";
                switch ($state) {
                    case 'available':
                        echo "
                        <form action='manageoffers.php' method='post'>
                        <input type='submit'  class='redirect-butt' value='Vedi le proposte'>
                        <input type='hidden' name='saleid' value='$id'>
                        </form>
                        <form action='salemanager.php' method='post'>
                        <input type='submit' class='redirect-butt' value='Elimina annuncio'>
                        <input type='hidden' name='saleid' value='$id'>
                        <input type='hidden' name='method' value='delete'>
                        </form>";
                        break;
                    case "closed":
                        $sql = "SELECT Users.username, Proposte.valore FROM Proposte
                                JOIN Users ON Users.email = Proposte.user_email
                                WHERE Proposte.annuncio_id = $id
                                AND Proposte.stato = 'accepted'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $username = $row["username"];
                        $sum = $row["valore"];
                        echo "<p>Acquirente: <a href='./showuser.php?user=$username'>$username</a></p>
                                <p>Prezzo di vendita: $sum €</p>";
                        break;
                    default:
                        
                        break;
                }
                echo "</div>";
            }
        } else{
            echo "<p class='errors'> Non hai ancora pubblicato annunci {$conn->error} </p>";
        }
    ?>

  

    <script src="js/script.js"></script>
</body>
</html>