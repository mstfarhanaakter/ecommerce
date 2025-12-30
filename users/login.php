<?php
session_start();
include __DIR__ . '/../config/database.php';

// if (isset($_SESSION['user_id'])) {
//     header("Location: /../index1.php");
//     exit;
// }

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT id, first_name, password, role, status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($user['status'] != 0) {
        $error = "Your account is inactive!";
} elseif (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../index1.php");
            exit;
        } else {
            $error = "Invalid email or password!";
        }
    } else {
        $error = "Invalid email or password!";
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

    <!-- Logo -->
    <div class="flex items-center justify-center space-x-2">
    <!-- Logo -->
    <img src="../assets/img/chick.png" class="w-14 h-14" alt="Logo">

    <!-- Texts side by side -->
    <span class="uppercase text-yellow-400 bg-black px-2 font-extrabold">Dora</span>
    <span class="uppercase text-gray-800 bg-yellow-400 px-2 font-extrabold">Mart</span>
</div>



    <h2 class="text-center font-bold text-gray-800 mb-6">
        Welcome back! Please log in.
    </h2>

    <?php if ($error): ?>
        <p class="text-center text-red-600 mb-4 font-semibold">
            <?= $error ?>
        </p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <input type="email" name="email" placeholder="Email" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">

        <div class="relative">
            <input type="password" name="password" id="password" placeholder="Password" required
                class="w-full px-4 py-2 border rounded-lg pr-10 focus:ring-2 focus:ring-green-400">
            <i id="togglePass"
               class="fa-solid fa-eye absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500"></i>
        </div>

        <button class="w-full bg-gradient-to-r from-yellow-400 to-green-500 font-bold py-3 rounded-lg hover:text-white">
            Login
        </button>
    </form>

    <p class="text-center text-sm mt-4 text-gray-500">
        Don’t have an account?
        <a href="register.php" class="text-green-600 hover:underline">Register</a>
    </p>
</div>

<script>
const toggle = document.getElementById("togglePass");
const pass   = document.getElementById("password");

toggle.addEventListener("click", () => {
    if (pass.type === "password") {
        pass.type = "text";
        toggle.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        pass.type = "password";
        toggle.classList.replace("fa-eye-slash", "fa-eye");
    }
});
</script>

</body>
</html>
