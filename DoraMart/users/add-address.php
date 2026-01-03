<?php
require __DIR__ . '/../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$flash = getFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name      = trim($_POST['full_name']);
    $phone          = trim($_POST['phone']);
    $address_type   = strtolower(trim($_POST['address_type']));
    $address_line1  = trim($_POST['address_line1']);
    $address_line2  = trim($_POST['address_line2'] ?? '');
    $city           = trim($_POST['city']);
    $state          = trim($_POST['state'] ?? '');
    $postal_code    = trim($_POST['postal_code']);
    $country        = trim($_POST['country'] ?? 'Bangladesh');
    $is_default     = isset($_POST['is_default']) ? 1 : 0;

    // address_type validate
    if (!in_array($address_type, ['home', 'office', 'other'])) {
        $address_type = 'home';
    }

    // Required fields
    if (empty($full_name) || empty($phone) || empty($address_line1) || empty($city) || empty($postal_code)) {
        $error = "Please fill all required fields.";
    } else {
        try {
            // If this is set as default, unset others
            if ($is_default) {
                $pdo->prepare("UPDATE addresses SET is_default = 0 WHERE user_id = ?")->execute([$user_id]);
            }

            $sql = "INSERT INTO addresses 
                    (user_id, address_type, full_name, phone, address_line1, address_line2, 
                     city, state, postal_code, country, is_default) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $user_id, $address_type, $full_name, $phone, $address_line1,
                $address_line2, $city, $state, $postal_code, $country, $is_default
            ]);

            setFlash('success', 'New address added successfully!');
            header("Location: addresses.php");
            exit();
        } catch (Exception $e) {
            $error = "Error adding address. Please try again.";
        }
    }
}

$page = 'addresses';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/topbar.php';
require __DIR__ . '/../includes/navbar.php';
?>

<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Add New Delivery Address</h2>

        <?php if ($flash): ?>
            <div class="mb-6 p-4 rounded-lg text-white <?= $flash['type'] === 'success' ? 'bg-green-600' : 'bg-red-600' ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300 text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="full_name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Type *</label>
                    <select name="address_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required>
                        <option value="home" <?= (($_POST['address_type'] ?? '') === 'home') ? 'selected' : '' ?>>Home</option>
                        <option value="office" <?= (($_POST['address_type'] ?? '') === 'office') ? 'selected' : '' ?>>Office</option>
                        <option value="other" <?= (($_POST['address_type'] ?? '') === 'other') ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1 *</label>
                    <input type="text" name="address_line1" value="<?= htmlspecialchars($_POST['address_line1'] ?? '') ?>" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2 (Optional)</label>
                    <input type="text" name="address_line2" value="<?= htmlspecialchars($_POST['address_line2'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                        <input type="text" name="city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">State / Division</label>
                        <input type="text" name="state" value="<?= htmlspecialchars($_POST['state'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                        <input type="text" name="postal_code" value="<?= htmlspecialchars($_POST['postal_code'] ?? '') ?>" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" name="country" value="<?= htmlspecialchars($_POST['country'] ?? 'Bangladesh') ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_default" id="is_default" class="h-5 w-5 text-indigo-600 rounded"
                           <?= isset($_POST['is_default']) ? 'checked' : '' ?> />
                    <label for="is_default" class="ml-3 text-gray-700 font-medium">Set as default address</label>
                </div>

                <div class="text-center pt-6">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-12 rounded-lg transition shadow-lg">
                        Add Address
                    </button>
                    <a href="addresses.php" class="ml-4 inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-12 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
            <a href="addresses.php" class="text-indigo-600 hover:underline font-medium">
                ← Back to My Addresses
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>