<?php
$hostName = "127.0.0.1";
$dbUser = "root";
$dbPassword = "1234";
$dbName = "fastbreak";
$port = 3306;

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName, $port);

if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");