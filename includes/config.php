<?php 
 // শুধুমাত্র যদি session চালু না থাকে, তখন শুরু হবে
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
                    }

    // define('BASE_URL', 'http://localhost/Final_DoraMart/');
    define('BASE_URL', '/Final_DoraMart/'); //project folder name 

?>