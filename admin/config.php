
// admin folder এর absolute path (server side)
// define('ADMIN_PATH', __DIR__);

// admin folder এর URL (browser side)
// define('ADMIN_URL', '/Final_DoraMart/admin');



<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index1.php");
    exit;
}
