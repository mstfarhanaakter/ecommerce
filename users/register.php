<?php
include __DIR__ . '/../config/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role       = 'user';
    $status     = 1; // default active

    // Check duplicate email
    $check = $con->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Email already registered!";
    } else {
        $stmt = $con->prepare("INSERT INTO users (first_name, last_name, email, password, role, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $password, $role, $status);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Something went wrong!";
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
<!-- Font Awesome for Eye Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-r from-yellow-200 via-green-100 to-green-300 flex items-center justify-center min-h-screen font-sans">

<!-- Registration Card -->
<div class="bg-white shadow-2xl rounded-3xl p-8 w-full max-w-md">
    <!-- Logo + Title side by side -->
    <div class="flex items-center justify-center mb-6 space-x-4">
        <img src="../assets/img/chick.png" alt="Logo" class="w-16 h-16 object-contain">
        <h2 class="text-2xl font-bold text-gray-800">Be Bold. Be First!</h2>
    </div>

    <!-- Message -->
    <?php if ($message): ?>
        <p class="text-center <?= $message === 'Registration successful!' ? 'text-green-600' : 'text-red-600' ?> mb-4">
            <?= $message ?>
        </p>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" class="w-full space-y-4">
        <div>
            <input type="text" name="first_name" id="first_name" placeholder="Your first name" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
        </div>

        <div>
            <input type="text" name="last_name" id="last_name" placeholder="Your last name" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
        </div>

        <div>
            <input type="email" name="email" id="email" placeholder="Your email" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 transition">
        </div>

         <!-- Password -->
        <div class="relative">
            <input type="password" name="password" id="password" placeholder="Password" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 pr-10">
            <i id="togglePass"
               class="fa-solid fa-eye absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500">
            </i>
        </div>

        <button type="submit" 
            class="w-full bg-gradient-to-r from-yellow-400 to-green-500 text-black font-bold py-3 rounded-lg hover:from-green-500 hover:to-yellow-400 hover:text-white transition">
            Register
        </button>
    </form>

    <p class="text-center text-gray-500 text-sm mt-4">
        Already have an account? <a href="login.php" class="text-green-600 hover:underline">Login here</a>
    </p>
</div>

<!-- Toggle Password Script -->
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
