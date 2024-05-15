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
                echo "<button onclick=" . "changePage('" . "login.php" . "'" . ") class='login-button'> Vai al Login </button>";
            }
            else{
                echo "<div>";
                echo "<img src={$_SESSION['profileimg']} class='profile-img'>";
                echo "<p> Ciao, {$_SESSION['username']} </p>";
                echo "</div>";
            }
        ?>    
    </header>

    <div class="viewer">
        <i class="bi bi-justify-right"></i>
    </div>

    <div class="navbar">  
        
    </div>

    <script src="js/script.js"></script>
</body>
</html>
