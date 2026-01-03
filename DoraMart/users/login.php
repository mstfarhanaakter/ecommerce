<?php

include __DIR__ . '/../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($login) || empty($password)) {
        $errors[] = "Username/Email and Password are required.";
    } else {
        // Username অথবা Email দিয়ে ইউজার খোঁজা
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Last login update
            $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);

            // Session set
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role']      = $user['role'];

            header("Location: ../index.php"); // তোমার ড্যাশবোর্ড পেজে চেঞ্জ করো
            exit;
        } else {
            $errors[] = "Wrong username/email or password.";
        }
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
<body class="bg-gradient-to-br from-green-50 to-yellow-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white shadow-2xl rounded-3xl p-8 w-full max-w-md">
        <!-- Logo + Title -->
        <div class="flex items-center justify-center space-x-2 mb-6">
            <img src="../assets/img/chick.png" class="w-14 h-14" alt="Logo">
            <span class="uppercase text-yellow-400 bg-black px-2 py-1 font-extrabold text-lg">Dora</span>
            <span class="uppercase text-gray-800 bg-yellow-400 px-2 py-1 font-extrabold text-lg">Mart</span>
        </div>
<h2 class="text-center font-bold text-gray-800 mb-6 text-xl">
            Welcome back! Please log in.
        </h2>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <?php foreach ($errors as $error): ?>
                    <p class="text-sm"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" class="w-full space-y-5">
            <!-- Username or Email -->
            <div>
                <input type="text" name="login" id="login" placeholder="Username or Email" required
                    value="<?= htmlspecialchars($login ?? '') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            </div>

            <!-- Password with toggle -->
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 pr-12 transition">
                <i id="togglePass" class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700"></i>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-yellow-400 to-green-500 text-black font-bold py-3 rounded-lg hover:from-green-500 hover:to-yellow-400 hover:text-white transition duration-300 transform hover:scale-105">
                Login
            </button>
        </form>

        <p class="text-center text-gray-500 text-sm mt-6">
            Don't have an account? <a href="register.php" class="text-green-600 font-medium hover:underline">Register here</a>
        </p>
    </div>

    <!-- Password Toggle Script -->
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