<?php
$hostName   = "127.0.0.1";
$dbUser = "root";
$dbPassword = ""; 
$dbName = "fastbreak";
$port = 3307;  
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName, $port);
if (!$conn) {
     die("DB connection failed: " . mysqli_connect_error());
}
?>