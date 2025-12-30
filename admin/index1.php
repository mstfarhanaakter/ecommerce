<?php
session_start();
include __DIR__ . '/../config/database.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT id, first_name, password, role, status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($user['status'] == 0) {
            $msg = "Admin account is disabled!";
        } elseif ($user['role'] !== 'admin') {
            $msg = "Access denied!";
        } elseif (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'admin';
            $_SESSION['last_activity'] = time(); // session timer (optional)
            header("Location: main.php");
            exit;
        } else {
            $msg = "Incorrect password!";
        }
    } else {
        $msg = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-yellow-200 via-green-100 to-green-300 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-2xl rounded-3xl p-8 w-full max-w-md">

    <div class="flex items-center justify-center space-x-2">
        <img src="../assets/img/admin-panel.png" class="w-14 h-14" alt="Logo">
    </div>

    <h2 class="text-center font-bold text-gray-800 mb-6">
        Hey Admin! Please log in.
    </h2>

    <?php if ($msg): ?>
        <p class="text-center text-red-600 mb-4 font-semibold">
            <?= $msg ?>
        </p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <input type="email" name="email" placeholder="Email" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">
        <div class="relative">
            <input type="password" name="password" id="password" placeholder="Password" required
                class="w-full px-4 py-2 border rounded-lg pr-10 focus:ring-2 focus:ring-green-400">
        </div>
        <button class="w-full bg-gradient-to-r from-yellow-400 to-green-500 font-bold py-3 rounded-lg hover:text-white">
            Login
        </button>
    </form>
</div>
</body>
</html>
