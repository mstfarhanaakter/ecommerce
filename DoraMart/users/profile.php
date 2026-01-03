<?php
// Start session and database connection first (no output yet)
require __DIR__ . '/../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error_message = '';

// Process form submission (before any HTML output)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $full_name     = trim($_POST['full_name'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $date_of_birth = $_POST['date_of_birth'] ?: null;
    $new_avatar    = null;

    // Handle avatar upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $size = $_FILES['avatar']['size'];

        if (in_array($ext, $allowed) && $size <= 2 * 1024 * 1024) {
            $new_avatar = "user_{$user_id}_" . time() . ".{$ext}";
            $upload_dir = __DIR__ . '/../uploads/avatars/';
            $upload_path = $upload_dir . $new_avatar;

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_path)) {
                // Delete old avatar
                $stmt = $pdo->prepare("SELECT avatar FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                $old = $stmt->fetch();

                if ($old && $old['avatar'] && $old['avatar'] !== 'default-avatar.png') {
                    $old_path = $upload_dir . $old['avatar'];
                    if (file_exists($old_path)) unlink($old_path);
                }
            } else {
                $error_message = "Failed to upload image.";
            }
        } else {
            $error_message = "Invalid file or too large (max 2MB). Only JPG, PNG, GIF allowed.";
        }
    }

    // Update database
    if (empty($error_message)) {
        try {
            if ($new_avatar) {
                $sql = "UPDATE users SET full_name = ?, phone = ?, date_of_birth = ?, avatar = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$full_name, $phone, $date_of_birth, $new_avatar, $user_id]);
            } else {
                $sql = "UPDATE users SET full_name = ?, phone = ?, date_of_birth = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$full_name, $phone, $date_of_birth, $user_id]);
            }

            setFlash('success', 'Profile updated successfully!');
            header("Location: profile.php");
            exit();
        } catch (Exception $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}

// Fetch user data
$stmt = $pdo->prepare("SELECT username, email, full_name, phone, date_of_birth, avatar FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

$flash = getFlash();

// Now include layout files (after processing)
$page = 'profile';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/topbar.php';
require __DIR__ . '/../includes/navbar.php';
?>

<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">My Profile</h2>

        <!-- Flash & Error Messages -->
        <?php if ($flash): ?>
            <div class="mb-6 p-4 rounded-lg text-white <?= $flash['type'] === 'success' ? 'bg-green-600' : 'bg-red-600' ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left: Current Profile Info -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Current Information</h3>

                <div class="flex flex-col items-center mb-8">
                    <img src="<?= $user['avatar'] ? '../uploads/avatars/' . htmlspecialchars($user['avatar']) : '../uploads/avatars/default-avatar.png' ?>"
                         alt="Profile Picture"
                         class="w-40 h-40 rounded-full object-cover border-4 border-indigo-500 shadow-xl">
                    <h4 class="mt-4 text-xl font-bold text-gray-800">
                        <?= htmlspecialchars($user['full_name'] ?: $user['username']) ?>
                    </h4>
                    <p class="text-gray-600"><?= htmlspecialchars($user['email']) ?></p>
                </div>

                <div class="space-y-4 text-lg">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-medium text-gray-600">Username:</span>
                        <span class="text-gray-800"><?= htmlspecialchars($user['username']) ?></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-medium text-gray-600">Full Name:</span>
                        <span class="text-gray-800"><?= htmlspecialchars($user['full_name'] ?: '<em>Not set</em>') ?></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-medium text-gray-600">Phone:</span>
                        <span class="text-gray-800"><?= htmlspecialchars($user['phone'] ?: '<em>Not set</em>') ?></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-medium text-gray-600">Date of Birth:</span>
                        <span class="text-gray-800">
                            <?= $user['date_of_birth'] ? date('F j, Y', strtotime($user['date_of_birth'])) : '<em>Not set</em>' ?>
                        </span>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="addresses.php" class="inline-block bg-yellow-400 hover:bg-black text-black hover:text-white font-semibold py-3 px-6 rounded-lg transition">
                        Manage Delivery Addresses
                    </a>
                </div>
            </div>

            <!-- Right: Update Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Update Profile</h3>

                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text"
                               name="full_name"
                               value="<?= htmlspecialchars($user['full_name'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="text"
                               name="phone"
                               value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                        <input type="date"
                               name="date_of_birth"
                               value="<?= htmlspecialchars($user['date_of_birth'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                        <input type="file"
                               name="avatar"
                               accept="image/jpeg,image/png,image/gif"
                               class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-yellow-400 file:text-black">
                        <p class="text-xs text-gray-500 mt-2">Max 2MB • JPG, PNG, GIF only</p>
                    </div>

                    <div class="text-center pt-4">
                        <button type="submit"
                                name="update_profile"
                                class="bg-yellow-400 hover:bg-black hover:text-white text-black font-bold py-3 px-10 rounded-lg transition transform hover:scale-105">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>