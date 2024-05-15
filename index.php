<?php
    session_start();
    include_once("connectdb.php");
    $conn = getConn();
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
    <title>RSAMarket | Homepage</title>
</head>
<body>
    <header>
        <img src="images/logo.jpg">
        <div class="div-header">
            <h1> RSA Market </h1>
            <p> Tutto quello che vuoi, proponendo il prezzo! </p>
        </div>
        <?php
            if(!isset($_SESSION["email"])){
                echo "<button onclick=changePage('login.php') class='login-button'> Vai al Login </button>";
            }
            else{
                echo "<div class='user-block' onclick=changePage('account.php')>";
                $profileimg = $_SESSION['profileimg'] ? "./" . $_SESSION['profileimg'] : "./images/defaultprofileimage.png";
                echo "<img class='profile-img' onclick='showOptions()' src=$profileimg>";
                echo "<p> {$_SESSION['username']} </p>";
                echo "</div>";
            }
        ?>    
    </header>

    <div class="viewer">
        <i class="bi bi-justify-right"></i>
    </div>

    <div class="navbar">  
        
    </div>

    <?php var_dump($_SESSION)?>

    <script src="js/script.js"></script>
</body>
</html>
