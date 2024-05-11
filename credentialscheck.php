<?php
function redirect($page)
{
    header("Location: ./$page");
    exit();
}

function isValid($var)
{
    return isset($var) && !empty($var) && $var != null;
}

function checkSessionCredentials(mysqli $conn)
{
    $email = $_SESSION["email"];
    $password = $_SESSION["password"];
    $errormessage = "<p class='errors'>credenziali di sessione invalide.</p>";

    if (!isset($email) || empty($email) || !isset($password) || empty($password)) {
        $_SESSION["login_error"] = $errormessage;
        redirect("login.php");
    }

    $sql = "select username,password from users where email = '$email'";


    $result = $conn->query($sql);

    if ($conn->affected_rows < 0) {
        $_SESSION["login_error"] = $errormessage;
        redirect("login.php");
    }

    $row = $result->fetch_assoc();

    if ($password != $row["password"]) {
        $_SESSION["login_error"] = $errormessage;
        redirect("login.php");
    }
}
?>