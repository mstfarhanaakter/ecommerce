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
$flash = getFlash();

// Handle Edit Mode
$editing_address = null;
$error = '';

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM addresses WHERE id = ? AND user_id = ?");
    $stmt->execute([$edit_id, $user_id]);
    $editing_address = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$editing_address) {
        setFlash('danger', 'Address not found or access denied.');
        header("Location: addresses.php");
        exit();
    }
}

// Process Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_address'])) {
    $address_id     = (int)$_POST['address_id'];
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

    if (!in_array($address_type, ['home', 'office', 'other'])) {
        $address_type = 'home';
    }

    if (empty($full_name) || empty($phone) || empty($address_line1) || empty($city) || empty($postal_code)) {
        $error = "Please fill all required fields.";
    } else {
        try {
            if ($is_default) {
                $pdo->prepare("UPDATE addresses SET is_default = 0 WHERE user_id = ?")->execute([$user_id]);
            }

            $sql = "UPDATE addresses SET 
                        address_type = ?, full_name = ?, phone = ?, address_line1 = ?, 
                        address_line2 = ?, city = ?, state = ?, postal_code = ?, 
                        country = ?, is_default = ? 
                    WHERE id = ? AND user_id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $address_type, $full_name, $phone, $address_line1,
                $address_line2, $city, $state, $postal_code,
                $country, $is_default, $address_id, $user_id
            ]);

            setFlash('success', 'Address updated successfully!');
            header("Location: addresses.php");
            exit();
        } catch (Exception $e) {
            $error = "Failed to update address. Please try again.";
        }
    }
}

// Fetch All Addresses
$stmt = $pdo->prepare("SELECT * FROM addresses WHERE user_id = ? ORDER BY is_default DESC, id DESC");
$stmt->execute([$user_id]);
$addresses = $stmt->fetchAll();

$page = 'addresses';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/topbar.php';
require __DIR__ . '/../includes/navbar.php';
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">My Delivery Addresses</h1>
                <p class="text-gray-600 mt-2">Manage your saved addresses for faster checkout</p>
            </div>
            <a href="add-address.php" class="inline-flex items-center bg-yellow-400 hover:bg-yellow-400 text-black font-semibold py-3 px-8 rounded-xl shadow-lg transition transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Address
            </a>
        </div>

        <!-- Flash Message -->
        <?php if ($flash): ?>
            <div class="mb-8 p-5 rounded-xl text-white font-medium shadow-md <?= $flash['type'] === 'success' ? 'bg-green-600' : 'bg-red-600' ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <!-- Edit Mode: Side-by-Side Layout -->
        <?php if ($editing_address): ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-16">
                <!-- Current Address -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Current Address</h3>
                        <?php if ($editing_address['is_default']): ?>
                            <span class="bg-yellow-400 text-black px-4 py-2 rounded-full text-sm font-semibold">Default</span>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-6 text-gray-700">
                        <div>
                            <p class="text-sm text-gray-500">Recipient</p>
                            <p class="text-lg font-semibold"><?= htmlspecialchars($editing_address['full_name']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="text-lg font-semibold"><?= htmlspecialchars($editing_address['phone']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Type</p>
                            <p class="text-lg font-semibold capitalize"><?= htmlspecialchars($editing_address['address_type']) ?> Address</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Delivery Address</p>
                            <p class="text-lg leading-relaxed">
                                <?= nl2br(htmlspecialchars($editing_address['address_line1'])) ?><br>
                                <?php if (!empty($editing_address['address_line2'])): ?>
                                    <?= nl2br(htmlspecialchars($editing_address['address_line2'])) ?><br>
                                <?php endif; ?>
                                <?= htmlspecialchars($editing_address['city']) ?>,
                                <?= htmlspecialchars($editing_address['state'] ?? '') ?>
                                <?= htmlspecialchars($editing_address['postal_code']) ?><br>
                                <?= htmlspecialchars($editing_address['country']) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Address</h3>

                    <?php if ($error): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-6">
                        <input type="hidden" name="address_id" value="<?= $editing_address['id'] ?>">
                        <input type="hidden" name="update_address" value="1">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" name="full_name" value="<?= htmlspecialchars($editing_address['full_name']) ?>" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="text" name="phone" value="<?= htmlspecialchars($editing_address['phone']) ?>" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address Type *</label>
                            <?php $current_type = strtolower(trim($editing_address['address_type'] ?? 'home')); ?>
                            <select name="address_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                                <option value="home" <?= $current_type === 'home' ? 'selected' : '' ?>>Home</option>
                                <option value="office" <?= $current_type === 'office' ? 'selected' : '' ?>>Office</option>
                                <option value="other" <?= $current_type === 'other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 1 *</label>
                            <input type="text" name="address_line1" value="<?= htmlspecialchars($editing_address['address_line1']) ?>" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2 (Optional)</label>
                            <input type="text" name="address_line2" value="<?= htmlspecialchars($editing_address['address_line2'] ?? '') ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" name="city" value="<?= htmlspecialchars($editing_address['city']) ?>" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State / Division</label>
                                <input type="text" name="state" value="<?= htmlspecialchars($editing_address['state'] ?? '') ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code *</label>
                                <input type="text" name="postal_code" value="<?= htmlspecialchars($editing_address['postal_code']) ?>" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                            <input type="text" name="country" value="<?= htmlspecialchars($editing_address['country']) ?>"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 transition" />
                        </div>

                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="is_default" id="is_default" class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500"
                                   <?= $editing_address['is_default'] ? 'checked' : '' ?> />
                            <label for="is_default" class="text-gray-700 font-medium">Set as default delivery address</label>
                        </div>

                        <div class="flex justify-end gap-4 pt-6">
                            <a href="addresses.php" class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-10 py-3 bg-yellow-400 hover:bg-black text-black hover:text-white font-semibold rounded-xl shadow-lg transition transform hover:scale-105">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        <?php else: ?>
            <!-- Address List -->
            <?php if (empty($addresses)): ?>
                <div class="bg-white rounded-2xl shadow-xl p-16 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">No addresses yet</h3>
                    <p class="text-gray-600 mb-8">Add your first delivery address to get started.</p>
                    <a href="add-address.php" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg transition">
                        Add Your First Address
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($addresses as $addr): ?>
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-8 border border-gray-100 relative overflow-hidden">
                            <?php if ($addr['is_default']): ?>
                                <div class="absolute top-0 right-0 bg-yellow-400 text-black px-6 py-2 text-sm font-bold rounded-bl-2xl">
                                    Default
                                </div>
                            <?php endif; ?>

                            <div class="mt-4">
                                <h3 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($addr['full_name']) ?></h3>
                                <p class="text-sm text-indigo-600 font-medium capitalize mt-1"><?= htmlspecialchars($addr['address_type']) ?> Address</p>
                            </div>

                            <div class="mt-6 text-gray-600 text-sm space-y-2">
                                <p class="font-medium"><?= htmlspecialchars($addr['address_line1']) ?></p>
                                <?php if ($addr['address_line2']): ?>
                                    <p><?= htmlspecialchars($addr['address_line2']) ?></p>
                                <?php endif; ?>
                                <p><?= htmlspecialchars($addr['city']) ?>, <?= htmlspecialchars($addr['state'] ?? '') ?> <?= htmlspecialchars($addr['postal_code']) ?></p>
                                <p><?= htmlspecialchars($addr['country']) ?></p>
                                <p class="font-semibold text-gray-800 mt-3">Phone: <?= htmlspecialchars($addr['phone']) ?></p>
                            </div>

                            <div class="mt-8 flex gap-3">
                                <a href="addresses.php?edit=<?= $addr['id'] ?>" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 py-3 rounded-lg font-medium transition">
                                    Edit
                                </a>
                                <?php if (!$addr['is_default']): ?>
                                    <a href="set-default-address.php?id=<?= $addr['id'] ?>" class="flex-1 text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition">
                                        Set Default
                                    </a>
                                <?php endif; ?>
                                <a href="delete-address.php?id=<?= $addr['id'] ?>" onclick="return confirm('Delete this address permanently?')"
                                   class="flex-1 text-center bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-medium transition">
                                    Delete
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mt-16 text-center">
                <a href="profile.php" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Profile
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>