<?php
session_start();
include_once("connectdb.php");
include_once("credentialscheck.php");
$conn = getConn();
checkSessionCredentials($conn);

if(!isset($_GET) || !array_key_exists("id",$_GET)){
    redirect("index.php");
}

$saleid = $_GET["id"];

if(!is_numeric($saleid)){
    redirect("index.php");
}

$sql = "SELECT Annunci.nome,Annunci.descrizione,Users.username,Users.fotoProfilo,Annunci.stato,Annunci.tipologia,Annunci.data
        FROM Annunci
        JOIN Users ON Annunci.user_email = Users.email
        WHERE Annunci.id = '$saleid'";
$result = $conn->query($sql);
$sale = null;
if($result->num_rows > 0 ){
    $sale = $result->fetch_assoc();
} else {
    redirect("index.php");
}

$salename = htmlspecialchars(urldecode($sale["nome"]));
$saledesc = htmlspecialchars(urldecode($sale["descrizione"]));
$saleauthor = $sale["username"];
$saleauthorprofileimg = $sale["fotoProfilo"] ? $sale["fotoProfilo"] : "./images/defaultprofileimage.png";
$salecat = $sale["tipologia"];
$salestate = $sale["stato"];
$saledate = $sale["data"];

$images = [];

$sql = "SELECT urlImg FROM Foto
        WHERE annuncio_id = '$saleid'";

$result = $conn->query($sql);

while (($row = $result->fetch_assoc()) != null) {
    $images[] = $row["urlImg"];
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
    <link rel="stylesheet" href="./css/style.css">
    <title>RSA Market | <?php echo $salename?> </title>
</head>
<body style="display: flex; align-items: center; justify-content: center;">
    <div class="sale-container">
        <h1> <?php echo $salename?> </h1>

        <div class="selected-image"><?php echo "<img src='{$images[0]}'>" ?></div>

        <div class="images-container">
            <?php
                for ($i=0; $i < count($images); $i++) { 
                    $url = $images[$i];
                    echo "<img src='$url'>";
                }
            ?>
        </div>
        
        <p> <?php echo $saledesc ?> </p>
        <div class="user-credential">
            <img src=<?php echo "'$saleauthorprofileimg'"?>>
            <p> Autore: <?php echo $saleauthor ?> </p>
        </div>

        <p> Categoria: <?php echo $salecat ?> </p>
        <p> Annuncio pubblicato in data: <?php echo $saledate ?> </p>

        <div class="redirect-container">
            <button onclick="showForm()" id="offer-button"> Effettua una proposta </button>
            <button onclick="changePage('index.php')"> Torna alla Homepage </button>
        </div>

        <form action="./offermanager.php" method="post" style="display: none" id="offer-form">
            <input type="number" name="sum" class="input-offer">
            <input type="hidden" name="saleid" value="1">
            <input type="hidden" name="method" value="create">
            <input type="submit" value="Invia Proposta">
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>