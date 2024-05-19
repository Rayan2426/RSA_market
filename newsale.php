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
    <title>Crea Annuncio</title>
</head>
<body>
    <form action="salemanager.php" method="post" enctype="multipart/form-data">
        <input type="text" name="titolo"><br>
        <input type="text" name="descrizione"><br>
        <?php
        $sql = "select nome from tipologie order by nome";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $select = "<select name='tipologia'>";
            while(($row = $result->fetch_assoc()) != null){
                $name = $row["nome"];
                $select .= "<option value='$name'>$name</option>";
            }
            $select .= "</select>";
            echo $select;
        }
        
        ?>
        <input type="file" name="foto1"><br>
        <input type="file" name="foto2"><br>
        <input type="file" name="foto3"><br>
        <input type="hidden" name="method" value="create"><br>
        <button type="submit">invia</button>
    </form>

    <?php
    echo !isset($_SESSION["sale_handler_error"]) || empty($_SESSION["sale_handler_error"]) 
    ? ""
    : $_SESSION["sale_handler_error"];
    ?>
</body>
</html>