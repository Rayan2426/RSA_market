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
        <img src="#" id="first_image">
        <input type="file" name="foto1" id="image1">
        <img src="#" id="second_image">
        <input type="file" name="foto2" id="image2" style="display: none;">
        <img src="#" id="third_image">
        <input type="file" name="foto3" id="image3" style="display: none;">

        <input type="hidden" name="method" value="create">
        <button type="submit">invia</button>
    </form>

    <?php
        echo !isset($_SESSION["sale_handler_error"]) || empty($_SESSION["sale_handler_error"]) 
        ? ""
        : "<p class='errors'> " . $_SESSION["sale_handler_error"] . "</p>";
    ?>

    <script>
        const images = [
            document.getElementById("image1"),
            document.getElementById("image2"),
            document.getElementById("image3")
        ];
        
        let image;

        for(let i = 1; i <= images.lenght; i++){
            if(images[i].value == ""){
                switch(i){
                    case 1:
                        image = document.getElementById("first_image");
                        break;
                    
                    case 2:
                        image = document.getElementById("second_image");
                        break;

                    case 3:
                        image = document.getElementById("third_image");
                        break;
                }
                showImage(i);
            }
        }
        
        function showImage(id){
            switch(id){
                case 1:
                    images[0].onchange = evt => {
                        const [file] = images[0].files;
                        if (file) {
                            image.src = URL.createObjectURL(file);
                        }
                    }

                    images[1].style.display = "block";
                    break;
                
                case 2:
                    images[1].onchange = evt => {
                        const [file] = images[1].files;
                        if (file) {
                            image.src = URL.createObjectURL(file);
                        }
                    }

                    images[2].style.display = "block";
                    break;

                case 3:
                    images[2].onchange = evt => {
                        const [file] = images[2].files;
                        if (file) {
                            image.src = URL.createObjectURL(file);
                        }
                    }

                    break;
            }
        }
        
    </script>
</body>
</html>