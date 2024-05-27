<?php
    session_start();
    include_once("connectdb.php");
    include_once("credentialscheck.php");
    $conn = getConn();
    checkSessionCredentials($conn);

    $method = $_POST["method"];

    switch ($variable) {
        case 'create':
            $sum = $_POST["sum"];
            $saleid = $_POST["saleid"];
            
            break;
        
        default:
            # code...
            break;
    }
?>