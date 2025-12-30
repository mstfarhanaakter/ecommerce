<?php
session_start();

// সব session variables clean করা
$_SESSION = [];

// session destroy করা
session_destroy();

// user কে login page এ redirect করা
header("Location: ../index1.php");
exit;
?>
