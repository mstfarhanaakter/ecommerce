<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// ইউজারের তথ্য নেয়া
$stmt = $pdo->prepare("
    SELECT u.name, u.email, 
           up.address, up.location, up.phone, up.date_of_birth, up.profile_image 
    FROM users u 
    LEFT JOIN users_profile up ON u.id = up.user_id 
    WHERE u.id = ?
");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// প্রোফাইল আপডেট লজিক
$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $dob = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null;

        // ইমেজ আপলোড
        $profile_image = $user['profile_image'];
        if (!empty($_FILES['profile_image']['name'])) {
            $upload_dir = 'uploads/profile/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            $file_name = time() . '_' . basename($_FILES['profile_image']['name']);
            $target = $upload_dir . $file_name;

            if ($_FILES['profile_image']['size'] > 2000000) {
                throw new Exception("Image size too large! Max 2MB.");
            }

            $allowed = ['jpg', 'jpeg', 'png'];
            $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                throw new Exception("Only JPG, JPEG & PNG allowed.");
            }

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
                $profile_image = $file_name;
                if ($user['profile_image'] && file_exists($upload_dir . $user['profile_image'])) {
                    unlink($upload_dir . $user['profile_image']);
                }
            } else {
                throw new Exception("Image upload failed.");
            }
        }

        // প্রোফাইল আপডেট/ইনসার্ট
        $stmt_check = $pdo->prepare("SELECT id FROM users_profile WHERE user_id = ?");
        $stmt_check->execute([$user_id]);
        if ($stmt_check->fetch()) {
            $stmt = $pdo->prepare("
                UPDATE users_profile 
                SET address = ?, location = ?, phone = ?, date_of_birth = ?, profile_image = ? 
                WHERE user_id = ?
            ");
            $stmt->execute([$address, $location, $phone, $dob, $profile_image, $user_id]);
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO users_profile (user_id, address, location, phone, date_of_birth, profile_image) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$user_id, $address, $location, $phone, $dob, $profile_image]);
        }

        // users টেবিলে নাম আপডেট
        if (!empty($name)) {
            $stmt_name = $pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
            $stmt_name->execute([$name, $user_id]);
        }

        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: user-profile.php");
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - My Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #f0f4ff 0%, #e6e9ff 100%); }
        .profile-wrapper { max-width: 1100px; margin: auto; }
        .profile-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        .left-sidebar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 60px 40px;
            text-align: center;
            min-height: 650px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .profile-avatar {
            width: 180px;
            height: 180px;
            border: 6px solid rgba(255,255,255,0.9);
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        .right-form {
            padding: 60px 50px;
            background: white;
        }
        .form-control-lg {
            border-radius: 12px;
        }
        .btn-primary {
            background: linear-gradient(90deg, #667eea, #764ba2);
            border: none;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102,126,234,0.4);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">DoraMart</a>
        <div class="ms-auto">
            <a href="cart.php" class="btn btn-outline-light me-2">Cart</a>
            <a href="user-profile.php" class="btn btn-outline-info me-2 active">Profile</a>
            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</nav>

<div class="container profile-wrapper py-5">
    <div class="row g-0 profile-card">

        <!-- Left Column: Profile Info -->
        <div class="col-lg-5 left-sidebar">
            <?php if (!empty($user['profile_image'])): ?>
                <img src="uploads/profile/<?= htmlspecialchars($user['profile_image']) ?>" 
                     class="rounded-circle profile-avatar mx-auto mb-4" alt="Profile">
            <?php else: ?>
                <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center profile-avatar mx-auto mb-4">
                    <i class="fas fa-user fa-5x"></i>
                </div>
            <?php endif; ?>

            <h3 class="mb-2"><?= htmlspecialchars($user['name'] ?? 'User') ?></h3>
            <p class="lead mb-4 opacity-90"><?= htmlspecialchars($user['email']) ?></p>

            <div class="mt-5 text-start">
                <h5 class="mb-4">Account Details</h5>
                <ul class="list-unstyled fs-5">
                    <li class="mb-4"><i class="fas fa-phone me-3 text-light"></i> <?= htmlspecialchars($user['phone'] ?? 'Not set') ?></li>
                    <li class="mb-4"><i class="fas fa-birthday-cake me-3 text-light"></i> <?= $user['date_of_birth'] ? date('d M Y', strtotime($user['date_of_birth'])) : 'Not set' ?></li>
                    <li class="mb-4"><i class="fas fa-map-marker-alt me-3 text-light"></i> <?= htmlspecialchars($user['location'] ?? 'Not set') ?></li>
                    <li><i class="fas fa-home me-3 text-light"></i> <?= nl2br(htmlspecialchars($user['address'] ?? 'Not set')) ?></li>
                </ul>
            </div>
        </div>

        <!-- Right Column: Update Form -->
        <div class="col-lg-7 right-form">
            <h4 class="mb-4 text-center text-primary fw-bold">Update Your Profile</h4>

            <form method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control form-control-lg" 
                               value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone Number</label>
                        <input type="tel" name="phone" class="form-control form-control-lg" 
                               value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control form-control-lg" 
                               value="<?= htmlspecialchars($user['date_of_birth'] ?? '') ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Full Address</label>
                        <textarea name="address" class="form-control form-control-lg" rows="1">
                            <?= htmlspecialchars($user['address'] ?? '') ?>
                        </textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Location (City/District)</label>
                        <input type="text" name="location" class="form-control form-control-lg" 
                               value="<?= htmlspecialchars($user['location'] ?? '') ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Profile Picture (JPG/PNG, max 2MB)</label>
                        <input type="file" name="profile_image" class="form-control form-control-lg" accept="image/jpeg,image/png">
                        <small class="text-muted mt-1 d-block">
                            Current: <?= $user['profile_image'] ? htmlspecialchars($user['profile_image']) : 'None uploaded' ?>
                        </small>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>