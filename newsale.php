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
    <link rel="stylesheet" href="./css/style.css"></header>
    <title>RSA Market | Crea Annuncio</title>
</head>
<body>
    <header>
        <img src="images/logo.jpg" onclick="changePage('index.php')">
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
                $profileimg = $_SESSION['profileimg'] ? $_SESSION['profileimg'] : "./images/defaultprofileimage.png";
                echo "<img class='profile-img' onclick='showOptions()' src=$profileimg>";
                echo "<p> {$_SESSION['username']} </p>";
                echo "</div>";
            }
        ?>    
    </header>

    <h3 class="h3-title"> Inserisci un nuovo annuncio compilando questo piccolo form. </h3>
    <button onclick="changePage('index.php')"> Torna alla Homepage </button>


    <form action="salemanager.php" method="post" enctype="multipart/form-data" class="form">
        <div class="div-label">
            <p>Titolo Annuncio</p>
            <input type="text" name="titolo">
        </div>
        <div class="div-label">
            <p>Descrizione Annuncio</p>
            <input type="text" name="descrizione">
        </div>
        
        <?php
            $sql = "select nome from Tipologie order by nome";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $select = "<select name='tipologia'>";
                while(($row = $result->fetch_assoc()) != null){
                    $name = $row["nome"];
                    $select .= "<option value='$name'>$name</option>";
                }
                $select .= "</select>";
                echo "<div class='div-label'>
                        <p>Categoria</p>
                        $select
                        </div>";
            }
        ?>

        <img src="#" id="first_image" style="display: none;" class="sale-img">
        <input type="file" name="foto1" id="foto1">
        <img src="#" id="second_image" style="display: none;" class="sale-img">
        <input type="file" name="foto2" id="foto2" style="display: none;">
        <img src="#" id="third_image" style="display: none;" class="sale-img">
        <input type="file" name="foto3" id="foto3" style="display: none;">

        <input type="hidden" name="method" value="create">
        <button type="submit">invia</button>
    </form>

    <?php
        echo !isset($_SESSION["sale_handler_error"]) || empty($_SESSION["sale_handler_error"]) 
        ? ""
        : "<p class='errors'> " . $_SESSION["sale_handler_error"] . "</p>";
    ?>

    <script>
            let fotoinput1 = document.getElementById("foto1");
            let fotoinput2 = document.getElementById("foto2");
            let fotoinput3 = document.getElementById("foto3");

            fotoinput1.onchange = evt => {
                const [file] = fotoinput1.files;
                if (file) {
                    let image = document.getElementById("first_image");
                    image.style.display = "block";
                    image.src = URL.createObjectURL(file);
                    fotoinput1.style.display = "none";
                    fotoinput2.style.display = "block";
                }
            }

            fotoinput2.onchange = evt => {
                const [file] = fotoinput2.files;
                if (file) {
                    let image = document.getElementById("second_image");
                    image.style.display = "block";
                    image.src = URL.createObjectURL(file);
                    fotoinput2.style.display = "none";
                    fotoinput3.style.display = "block";
                }
            }

            fotoinput3.onchange = evt => {
                const [file] = fotoinput3.files;
                if (file) {
                    let image = document.getElementById("third_image");
                    image.style.display = "block";
                    image.src = URL.createObjectURL(file);
                    fotoinput3.style.display = "none";
                }
            }
    </script>
    <script src="./js/script.js"></script>
</body>
</html>