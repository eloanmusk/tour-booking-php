<?php

date_default_timezone_set('Asia/Kathmandu');
$host = "localhost";
$username = "root";
$password = "";
$dbname = "userDB";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error<br>";
    echo $e->getMessage();
}

?>