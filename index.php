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
    <?php
        $sql = "select ID,nome,descrizione,user_email,stato,tipologia,data
                from Annunci";

        if(array_key_exists("q",$_GET) && isset($_GET["q"])){
            $q = $_GET["q"];
            $args = explode(" ",$q);
            $sql .= " WHERE ";
            foreach($args as $arg){
                $sql .= "nome LIKE '%$arg%'
                        OR descrizione LIKE '%$arg%'
                        OR user_email LIKE '%$arg%' OR ";
            }
            $sql = substr($sql, 0, -4);
            echo $sql;
        }
        
        $results = $conn->query($sql);

        if($results->num_rows > 0){
            while (($row = $results->fetch_assoc()) != null) {
                $idann = $row["ID"];
                $title = urldecode($row["nome"]);
                $desc = urldecode($row["descrizione"]);
                $state = $row["stato"];
                $author = $row["user_email"];
                $category = $row["tipologia"];
                $date = $row["data"];

                $sql = "select urlImg from Foto
                        WHERE
                        Annuncio_ID = '$idann'
                        ORDER BY urlImg
                        LIMIT 1";
                        
                $imageann = $conn->query($sql);
                $imageann = $imageann->fetch_assoc()["urlImg"];
                
                echo "<div>
                    Nome: $title <br>
                    Descrizione: $desc <br>
                    Stato: $state <br>
                    Autore: $author <br>
                    Categoria: $category <br>
                    Data di pubblicazione: $date <br>
                    <img src='$imageann'> <br>
                    </div>";
            }
        } else{
            echo "non sono ancora presenti annunci nel database";
        }
    ?>
    <div class="viewer" id="viewer">
        <i class="bi bi-justify-right element-viewer" onclick="show()" id="element-viewer"></i>
    </div>

    <div class="div-filter" id="filter-box" style="display: none;">
        <i class="bi bi-justify-left element-viewer" onclick="show()" id="element-viewer"></i>  
        <h1>Applica un filtro su:</h1>
        <form action="index.php" method="get">
            <div class="div-label">
                <select name="category">
                    <option value=""></option>
                </select>
            </div>
            <div class="div-label">
                <p> Nome </p>
                <input type="text" name="q">
            </div>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
