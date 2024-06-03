<?php
    session_start();
    include_once("connectdb.php");
    include_once("credentialscheck.php");
    $conn = getConn();
    checkSessionCredentials($conn);
    if($_SESSION["username"] != "admin"){
        redirect("index.php");
    }

    $quser = null;
        if(array_key_exists("quser", $_GET)){
            $quser = urlencode($_GET["quser"]);
        }
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
    <title>RSA Market | Admin Page</title>
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
    </header
    >
    <form action="admin.php" method="get">
        <input type="text" name="quser" placeholder="Cerca per utente..." style=" margin-left: auto; margin-right: auto; width: 80%; height: 30px; font-size: 18px;">
    </form>
    <?php
        $sql  = "SELECT Users.username, Users.email, UserLogs.logTime FROM Users
                JOIN UserLogs ON Users.email = UserLogs.user_email";
        if($quser){
            $sql .= " WHERE Users.username = '$quser'";
        }
        $sql .=" ORDER BY Userlogs.logTime DESC";
        $results = $conn->query($sql);

        if($results->num_rows > 0){
            while($row = $results->fetch_assoc()){
                $username = $row["username"];
                $email = $row["email"];
                $log = $row["logTime"];

                echo "
                    <div class='sale-box'>
                        <p>Username: $username </p>
                        <p>Email: $email </p>
                        <p>Log Time: $log </p>
                    </div>
                ";
            }
        }
    ?>
</body>
</html>