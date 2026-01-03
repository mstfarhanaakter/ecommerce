<?php
include __DIR__ . '/../config/database.php';

$errors = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $password  = $_POST['password'] ?? '';

    // Validation
    if (empty($username) || empty($email) || empty($full_name) || empty($password)) {
        $errors[] = "Username, Email, Full Name and Password are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($errors)) {
        // Check duplicate username or email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Username or Email already taken.";
        } else {
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Phone removed from INSERT
            $stmt = $pdo->prepare("INSERT INTO users 
                (username, email, password_hash, full_name, role, status, created_at, updated_at)
                VALUES (?, ?, ?, ?, 'user', 'active', NOW(), NOW())");

            if ($stmt->execute([$username, $email, $password_hash, $full_name])) {
                $message = "Registration successful!";
            } else {
                $errors[] = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-yellow-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white shadow-2xl rounded-3xl p-8 w-full max-w-md">
        <!-- Logo + Title -->
        <div class="flex items-center justify-center mb-6 space-x-4">
            <img src="../assets/img/chick.png" alt="Logo" class="w-16 h-16 object-contain">
            <h2 class="text-2xl font-bold text-gray-800">Be Bold. Be First!</h2>
        </div>

        <!-- Success Message -->
        <?php if ($message): ?>
            <p class="text-center text-green-600 mb-4 font-medium"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <?php foreach ($errors as $error): ?>
                    <p class="text-sm"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form method="POST" class="w-full space-y-5">
            <!-- Username -->
            <div>
                <input type="text" name="username" id="username" placeholder="Username" required
                    value="<?= htmlspecialchars($username ?? '') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            </div>

            <!-- Full Name -->
            <div>
                <input type="text" name="full_name" id="full_name" placeholder="Full Name" required
                    value="<?= htmlspecialchars($full_name ?? '') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            </div>

            <!-- Email -->
            <div>
                <input type="email" name="email" id="email" placeholder="Your email" required
                    value="<?= htmlspecialchars($email ?? '') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            </div>

            <!-- Password with toggle -->
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Password (min 6 chars)" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 pr-12 transition">
                <i id="togglePass" class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700"></i>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-yellow-400 to-green-500 text-black font-bold py-3 rounded-lg hover:from-green-500 hover:to-yellow-400 hover:text-white transition duration-300 transform hover:scale-105">
                Register
            </button>
        </form>

        <p class="text-center text-gray-500 text-sm mt-6">
            Already have an account? <a href="login.php" class="text-green-600 font-medium hover:underline">Login here</a>
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