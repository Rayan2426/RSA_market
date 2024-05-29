<?php
    session_start();
    include_once("connectdb.php");
    include_once("credentialscheck.php");
    $conn = getConn();
    checkSessionCredentials($conn);

    $method = $_POST["method"];

    switch ($method) {
        case 'create':
            $sum = $_POST["sum"];
            $saleid = $_POST["saleid"];
            $email = $_SESSION["email"];

            if(!is_numeric($sum)){
                redirect("index.php");
            } else if( intval($sum) <= 0){
                redirect("index.php");
            }

            $sql = "SELECT count(*) FROM Proposte
                    JOIN Annunci ON Annunci.id = Proposte.annuncio_id
                    WHERE Proposte.email = '$email' AND Annunci.id = $saleid";
            $hasAlreadyOffered = $conn->query($sql);

            if($hasAlreadyOffered){
                redirect("./showsale.php?id=$saleid");
            }

            $sql = "INSERT INTO Proposte(valore,annuncio_id,stato,user_email)
                    VALUE($sum,$saleid,'available','$email')";
            $conn->query($sql);

            if($conn->affected_rows > 0){
                echo "success";
            } else{
                echo "failure";
            }

            break;
        
        default:
            # code...
            break;
    }
?>