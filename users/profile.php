<?php 
$page = 'profile';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';    
include __DIR__ . '/../includes/navbar.php';

// Ensure user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ../login.php");
    exit;
}

// Fetch basic user info
$stmt = $con->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    echo "<div class='text-red-500'>User not found.</div>";
    exit;
}

// Fetch extended profile info
$stmt = $con->prepare("SELECT phone_number, location, address, date_of_birth, profile_picture FROM user_profile WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$profile_result = $stmt->get_result();
$profile = $profile_result->fetch_assoc() ?? [
    'phone_number' => '',
    'location' => '',
    'address' => '',
    'date_of_birth' => '',
    'profile_picture' => ''
];
?>

<div class="max-w-7xl mx-auto my-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Your Profile</h2>

    <!-- Two-column layout -->
    <div class="flex flex-col md:flex-row gap-10">
        
        <!-- Left: Profile Info Card -->
        <div class="md:w-1/3 bg-gray-50 p-6 rounded-lg shadow-sm">
            <div class="w-40 h-40 rounded-full overflow-hidden mx-auto mb-6 border-2 border-gray-300">
                <?php if(!empty($profile['profile_picture']) && file_exists("../users_image/" . $profile['profile_picture'])): ?>
                    <img src="../users_image/<?php echo htmlspecialchars($profile['profile_picture']); ?>" alt="Profile Picture" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-lg">No Image</div>
                <?php endif; ?>
            </div>

            <h3 class="text-2xl font-semibold text-center mb-4"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
            
            <div class="space-y-2 text-gray-700">
                <p><span class="font-semibold">Email:</span> <?php echo htmlspecialchars($user['email']); ?></p>
                <?php if(!empty($profile['phone_number'])): ?>
                    <p><span class="font-semibold">Phone:</span> <?php echo htmlspecialchars($profile['phone_number']); ?></p>
                <?php endif; ?>
                <?php if(!empty($profile['address'])): ?>
                    <p><span class="font-semibold">Address:</span> <?php echo htmlspecialchars($profile['address']); ?></p>
                <?php endif; ?>
                <?php if(!empty($profile['location'])): ?>
                    <p><span class="font-semibold">District:</span> <?php echo htmlspecialchars($profile['location']); ?></p>
                <?php endif; ?>
                <?php if(!empty($profile['date_of_birth'])): ?>
                    <p><span class="font-semibold">Date of Birth:</span> <?php echo htmlspecialchars($profile['date_of_birth']); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right: Update Profile Form -->
        <div class="md:w-2/3 bg-gray-50 p-6 rounded-lg shadow-sm">
            <h3 class="text-2xl font-semibold mb-6 text-gray-800">Update Profile</h3>
            
            <?php if(isset($_SESSION['profile_message'])): ?>
                <div class="mb-4 p-4 rounded bg-green-100 text-green-700 font-medium">
                    <?php echo $_SESSION['profile_message']; unset($_SESSION['profile_message']); ?>
                </div>
            <?php endif; ?>

            <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">First Name</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Last Name</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone Number</label>
                    <input type="text" name="phone_number" value="<?php echo htmlspecialchars($profile['phone_number']); ?>" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">District</label>
                    <input type="text" name="location" value="<?php echo htmlspecialchars($profile['location']); ?>"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Address</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($profile['address']); ?>"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($profile['date_of_birth']); ?>"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Profile Picture</label>
                    <input type="file" name="profile_picture"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Full-width submit button -->
                <div class="md:col-span-2">
                    <button type="submit" name="update_profile"
                        class="w-full bg-yellow-500 hover:bg-yellow-400 text-black px-6 py-3 rounded-md font-semibold transition duration-200">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div> 
</div>


<?php 
include __DIR__ . '/../includes/footer.php';
?>
