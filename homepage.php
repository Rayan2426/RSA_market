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
            if(!isset($_SESSION["username"])){
                echo "<p> Effettua il Login: </p>";
                echo "<button onclick='changePage('login.php')'> Vai al Login </button>";
            }
            else{
                echo "<img src={$_SESSION['profileimg']} width=25 height=25>";
                echo "<p> Ciao, {$_SESSION['username']} </p>";
            }
        ?>    
    </header>

    <i class="bi bi-justify-left"></i>

    <div class="navbar">  
        
    </div>
</body>
</html>


<?php
echo "<p>{$_SESSION['username']}</p>
<img src={$_SESSION['profileimg']} width=25 height=25>";
?>
