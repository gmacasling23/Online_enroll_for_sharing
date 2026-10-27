<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "online_enroll"; 
$port = 3306;  

try {
    $mysqli = new mysqli($host, $user, $pass, $db, $port);
    if ($mysqli->connect_errno) {
        throw new Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>