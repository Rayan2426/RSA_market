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
    <title>Admin page</title>
</head>
<body>
    <form action="admin.php" method="get">
        <input type="text" name="quser" placeholder="Cerca per utente...">
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

                echo "<div>
                <p>Username: $username</p>
                <p>Email: $email</p>
                <p>Log Time: $log</p>
                </div>";
            }
        }
    ?>
</body>
</html>