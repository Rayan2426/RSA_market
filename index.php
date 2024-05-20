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
    <button onclick="changePage('newsale.php')">Inserisci nuovo annuncio</button>
    <div class="viewer" id="viewer">
        <i class="bi bi-justify-right element-viewer" onclick="show()" id="element-viewer"></i>
    </div>

    <div class="div-filter" id="filter-box" style="display: none;">
        <i class="bi bi-justify-left element-viewer" onclick="show()" id="element-viewer"></i>  
        <h1>Applica un filtro su:</h1>
        <form action="index.php" method="get">
            <div class="div-label">
            <?php
            $sql = "select nome from Tipologie order by nome";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $select = "<select name='category'>
                            <option value='any'>any</option>";
                while(($row = $result->fetch_assoc()) != null){
                    $name = $row["nome"];
                    $select .= "<option value='$name'>$name</option>";
                }
                $select .= "</select>";
                echo $select;
            }
        ?>
            </div>
            <div class="div-label">
                <p> Nome </p>
                <input type="text" name="q">
            </div>
            <button style="font-size: 40px;" type="submit">Vai</button>
        </form>
    </div>
    <?php
        $sql = "SELECT Annunci.ID,Annunci.nome,Annunci.descrizione,Users.username,Users.fotoProfilo,Annunci.stato,Annunci.tipologia,Annunci.data
                FROM Annunci
                JOIN Users ON Users.email = Annunci.user_email";
        $conditionated = false;

        if(array_key_exists("q",$_GET) && isValid($_GET["q"])){
            $q = urlencode($_GET["q"]);
            $args = explode("%20",$q);
            $sql .= " WHERE (";
            foreach($args as $arg){
                $sql .= "Annunci.nome LIKE '%$arg%'
                        OR Annunci.descrizione LIKE '%$arg%'
                        OR Users.username LIKE '%$arg%' OR ";
            }
            $sql = substr($sql, 0, -3) . ")";
            $conditionated = true;
        }

        if(array_key_exists("category",$_GET) && isValid($_GET["category"]) && $_GET["category"] !== "any"){
            $category = urlencode($_GET["category"]);
            $sql .= $conditionated ? " AND " : " WHERE ";
            $sql .= " Annunci.tipologia = '$category'";
            $conditionated = true;
        }
        
        $results = $conn->query($sql . " ORDER BY Annunci.data DESC");
        
        if($results->num_rows > 0){
            while (($row = $results->fetch_assoc()) != null) {
                $idann = $row["ID"];
                $title = urldecode($row["nome"]);
                $desc = urldecode($row["descrizione"]);
                $state = $row["stato"];
                $author = $row["username"];
                $authorpfp = isset($row["fotoProfilo"]) ? $row["fotoProfilo"] : "./images/defaultprofileimage.png";
                $category = $row["tipologia"];
                $date = $row["data"];

                $sql = "SELECT urlImg from Foto
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
                    <div>
                    <img src='$authorpfp' style=\"height:30px; width=30px; border-radius: 15px\"> Autore: $author<br>
                    </div>
                    Categoria: $category <br>
                    Data di pubblicazione: $date <br>
                    <img src='$imageann' width=300px> <br>
                    </div>";
            }
        } else{
            echo "nessun annuncio trovato che rispetti i criteri di ricerca<br>{$conn->error}";
        }
    ?>

    <script src="js/script.js"></script>
</body>
</html>
