<?php
session_start();
include_once("connectdb.php");
include_once("credentialscheck.php");
$conn = getConn();
checkSessionCredentials($conn);

var_dump($_SESSION);
?>

zucci lavora e facci sta index

<br>
<br>
<br>

<?php
echo "<p>{$_SESSION['username']}</p>
<img src={$_SESSION['profileimg']} width=256 height=256>";
?>