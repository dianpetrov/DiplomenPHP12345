<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "1234";
$dbName = "fastbreak";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}
?>