<?php

session_start();

// Session timeout (optional, 30 minutes)
$timeout = 1800;
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
} elseif (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}
$_SESSION['last_activity'] = time();