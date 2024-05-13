<?php
session_start();
include_once("connectdb.php");
include_once("credentialscheck.php");
$conn = getConn();
checkSessionCredentials($conn);
?>

zucci lavora e facci sta index

<br>
<br>
<br>

<?php
echo "<p>{$_SESSION['username']}</p>
<img src={$_SESSION['profileimg']} width=25 height=25>";
?>