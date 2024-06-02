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

$sql = "SELECT Annunci.nome,Annunci.descrizione,Users.email,Users.username,Users.fotoProfilo,Annunci.stato,Annunci.tipologia,Annunci.data
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
$saleauthoremail = $sale["email"];
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

$canOffer = !($_SESSION["email"] === $saleauthoremail);

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

        <div class="selected-image"><?php echo "<img src='{$images[0]}'  id='mainimage'>" ?></div>

        <div class="images-container">
            <?php
                for ($i=0; $i < count($images); $i++) { 
                    $url = $images[$i];
                    echo "<img src='$url' id='img$i' onclick='changeImg(\"img$i\")' style='cursor: pointer'>";
                }
            ?>
        </div>
        
        <p> <?php echo $saledesc ?> </p>
        <div class="user-credential">
            <a href=<?php echo "'./showuser.php?user=" . $saleauthor . "'";?>><img src=<?php echo "'$saleauthorprofileimg'"?> style="width: 50px; height: 50px;">
            <p> <?php echo $saleauthor ?> </p>
            </a>
        </div>

        <p> Categoria: <?php echo $salecat ?> </p>
        <p> Annuncio pubblicato in data: <?php echo $saledate ?> </p>

        <div class="redirect-container">
            <?php
                if($canOffer){
                    echo"<button onclick=\"showForm()\" id=\"offer-button\"> Effettua una proposta </button>";
                }
            ?>
            <button onclick="changePage('index.php')"> Torna alla Homepage </button>
        </div>
        <?php
                if($canOffer){
                    echo"<form action=\"./offermanager.php\" method=\"post\" style=\"display: none\" id=\"offer-form\">
                    <input type=\"number\" name=\"sum\" class=\"input-offer\">
                    <input type=\"hidden\" name=\"saleid\" value=\"$saleid\">
                    <input type=\"hidden\" name=\"method\" value=\"create\">
                    <input type=\"submit\" value=\"Invia Proposta\">
                </form>";
                }

                if(isset($_SESSION["offer_handler_error"]) && !empty($_SESSION["offer_handler_error"])){
                    echo $_SESSION["offer_handler_error"];
                    $_SESSION["offer_handler_error"] = null;
                }

                switch ($salestate) {
                    case 'closed':
                        echo "L'annuncio e' stato chiuso: il venditore ha trovato un'acquirente";
                        break;
                    case 'deleted':
                        echo "L'annuncio e' stato eliminato";
                        break;
                    case 'available':
                        echo "L'annuncio e' ancora disponibile";
                        break;
                }
            ?>
    </div>

    <script src="js/script.js"></script>
    <script>
        function changeImg(id){
            let maingimg =document.getElementById("mainimage");
            let newimg =document.getElementById(id);
            maingimg.src =newimg.src;
        }
    </script>
</body>
</html>