<?php 
//database credentials

$host = 'localhost';
$db = 'final_doramart';
$username = 'root';
$password = '';

// create connection

$con = new mysqli($host, $username, $password, $db);

//chceck connection 
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


// Optional: set charset
// $con->set_charset("utf8mb4");


?>