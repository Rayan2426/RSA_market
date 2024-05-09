<?php

function getConn()
{
    $user = "root";
    $pass = "";
    $server = "localhost";
    $dbname = "rsa_market";

    mysqli_report(MYSQLI_REPORT_OFF);

    $conn = new mysqli($server, $user, $pass, $dbname);

    if ($conn->connect_error) {
        echo "AN ERROR OCCURRED DURING THE CONNECTION TO THE DATABASE<br>";
        exit();
    }

    return $conn;
}