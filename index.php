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

    <div class="elements-box">
        <div class="insert-box">
            <button onclick="changePage('newsale.php')">Inserisci nuovo annuncio</button>
            <button onclick="changePage('myoffers.php')">Le tue proposte</button>
        </div>
        <div class="viewer" id="viewer">
            <i class="bi bi-justify-right element-viewer" onclick="show()" id="element-viewer"></i>
        </div>
    </div>

    <!-- filter boxes -->
    <div class="div-filter" id="filter-box" style="display: none;">
        <i class="bi bi-justify-left element-viewer" onclick="show()" id="element-viewer"></i>  
        <h1>Applica un filtro su:</h1>
        <form action="index.php" method="get" class="form-filter">
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
            
            <button type="submit" style="margin-bottom: 20px">Vai</button>
        </form>
    </div>
    
    <div class="sales-container">
    <?php
        $sql = "SELECT Annunci.ID,Annunci.nome,Annunci.descrizione,Users.username,Users.fotoProfilo,Annunci.stato,Annunci.tipologia,Annunci.data
                FROM Annunci
                JOIN Users ON Users.email = Annunci.user_email
                WHERE Annunci.stato = 'available' ";

        if(array_key_exists("q", $_GET) && isValid($_GET["q"])){
            $q = urlencode($_GET["q"]);
            $args = explode("%20", $q);
            $sql .= " AND (";
            foreach($args as $arg){
                $sql .= "Annunci.nome LIKE '%$arg%'
                        OR Annunci.descrizione LIKE '%$arg%'
                        OR Users.username LIKE '%$arg%' OR ";
            }
            $sql = substr($sql, 0, -3) . ")";
        }

        if(array_key_exists("category",$_GET) && isValid($_GET["category"]) && $_GET["category"] !== "any"){
            $category = urlencode($_GET["category"]);
            $sql .= " AND ";
            $sql .= " Annunci.tipologia = '$category'";
            $conditionated = true;
        }
        
        $results = $conn->query($sql . " ORDER BY Annunci.data DESC");
        
        if($results->num_rows > 0){
            while (($row = $results->fetch_assoc()) != null) {
                $idann = $row["ID"];
                $title = htmlspecialchars(urldecode($row["nome"]));
                $desc = htmlspecialchars(urldecode($row["descrizione"]));
                $state = $row["stato"];
                $author = $row["username"];
                $authorpfp = isset($row["fotoProfilo"]) ? $row["fotoProfilo"] : "./images/defaultprofileimage.png";
                $category = $row["tipologia"];
                $date = $row["data"];

                $sql = "SELECT urlImg from foto
                        WHERE
                        Annuncio_ID = $idann
                        ORDER BY urlImg";

                $imageann = $conn->query($sql);
                $imageann = $imageann->fetch_assoc()["urlImg"];
                
                echo "<div class='sale-box' onclick='changePage(\"showsale.php?id=$idann\")'>
                        <img src='$imageann' width=300px>
                        <p> Nome: $title </p>
                        <div>
                            <img src='$authorpfp' style=\"height:30px; width=30px; border-radius: 15px\" id='foto_autore'> 
                            <span id='autore'> $author </span>
                        </div>
                        <p style='margin: 10px;'> Categoria: $category </p>
                    </div>";
            }
        } else{
            echo "nessun annuncio trovato che rispetti i criteri di ricerca<br>{$conn->error}";
        }
    ?>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
