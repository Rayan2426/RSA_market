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
    <link rel="stylesheet" href="css/style.css">
    <title>RSA Market | Visualizza Utente</title>
</head>
<body>
    <?php
        $username = null;
        if(array_key_exists("user", $_GET)){
            $username = urlencode($_GET["user"]);
            $sql = "SELECT username,email,fotoProfilo
                    FROM Users
                    WHERE username = '$username'";
            $row = $conn->query($sql)->fetch_assoc();
            $username = $row["username"];
            $email = $row["email"];
            $profileimg = isset($row["fotoProfilo"]) && isValid($row["fotoProfilo"]) ? $row["fotoProfilo"] : "./images/defaultprofileimage.png";

            echo "<div style='margin-top: 20px; width: 300px; display: flex; flex-direction: column; align-content: center; justify-content: center; gap: 20px; margin-left: auto; margin-right: auto;'>
                    <img src='$profileimg' height=100px width=100px>
                    <p> Username: $username </p>
                    <p> Email: $email </p>        
                </div>";

            $sql = "SELECT Annunci.ID,Annunci.nome,Annunci.descrizione,Annunci.stato,Annunci.tipologia,Annunci.data
                    FROM Annunci
                    JOIN Users ON Annunci.user_email = Users.email
                    WHERE username='$username'
                    AND Annunci.stato = 'available'";

            $results = $conn->query($sql);

            if($results->num_rows > 0){
                while($row = $results->fetch_assoc()){
                    $idann = $row["ID"];
                    $title = htmlspecialchars(urldecode($row["nome"]));
                    $desc = htmlspecialchars(urldecode($row["descrizione"]));
                    $category = $row["tipologia"];
                    $date = $row["data"];

                    $sql = "SELECT urlImg from Foto
                            WHERE
                            Annuncio_ID = $idann
                            ORDER BY urlImg";

                    $imageann = $conn->query($sql);
                    $imageann = $imageann->fetch_assoc()["urlImg"];
                    
                    echo "<div class='sale-box' style='margin-left: auto; margin-right: auto; margin: 20px;' onclick='changePage(\"showsale.php?id=$idann\")'>
                            <a href='./showsale.php?id=$idann' class='links' style='margin: 10px'>
                                <img src='$imageann' width=300px> $title
                            </a>
                            <p style='margin: 10px'> Categoria: $category </p>
                        </div>";
                }
            } else{
                echo "<p class='errors'> Questo utente non ha ancora pubblicato annunci </p>";
            }
        } else {
            echo "<p class='errors'> Nessun parametro di ricerca selezionato</p>";
        }
    ?>
</body>
</html>
