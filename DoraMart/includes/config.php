
<?php
// config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// প্রজেক্টের রুট URL — সবসময় trailing slash রাখো
define('BASE_URL', '/DoraMart/');           // লোকাল / সাবফোল্ডারে
// define('BASE_URL', 'https://doramart.com/'); // লাইভ সাইটে

// সহজে ব্যবহারের জন্য
define('ASSETS_URL', BASE_URL . 'assets/');
define('UPLOADS_URL', BASE_URL . 'uploads/');
?>