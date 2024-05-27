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


            $sql = "insert into Proposte(valore,Annuncio_ID,Stato,User_email)
                    value($sum,$saleid,'available','$email')";
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