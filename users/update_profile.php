<?php
include __DIR__ . '/../includes/header.php'; // includes session & $con
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: ../login.php");
    exit;
}

// Only process if form submitted
if (isset($_POST['update_profile'])) {

    // Collect and sanitize inputs
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $location = trim($_POST['location']);
    $address = trim($_POST['address']);
    $date_of_birth = trim($_POST['date_of_birth']);

    // Simple validation (add more if needed)
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number)) {
        $_SESSION['profile_message'] = "Please fill in all required fields.";
        header("Location: profile.php");
        exit;
    }

    // Handle profile picture upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExts = ['jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedExts)) {
            $newFileName = $user_id . '_' . time() . '.' . $fileExtension;
            $uploadDir = '../users_image/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            move_uploaded_file($fileTmpPath, $uploadDir . $newFileName);
            $profile_picture = $newFileName;
        } else {
            $_SESSION['profile_message'] = "Invalid image type. Only JPG, JPEG, PNG allowed.";
            header("Location: profile.php");
            exit;
        }
    }

    // Begin database updates
    // 1. Update users table
    $stmt = $con->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
    $stmt->execute();
    $stmt->close();

    // 2. Check if user_profile exists
    $stmt = $con->prepare("SELECT id FROM user_profile WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile_exists = $result->num_rows > 0;
    $stmt->close();

    if ($profile_exists) {
        // Update user_profile
        if ($profile_picture) {
            $stmt = $con->prepare("UPDATE user_profile SET phone_number=?, location=?, address=?, date_of_birth=?, profile_picture=? WHERE user_id=?");
            $stmt->bind_param("sssssi", $phone_number, $location, $address, $date_of_birth, $profile_picture, $user_id);
        } else {
            $stmt = $con->prepare("UPDATE user_profile SET phone_number=?, location=?, address=?, date_of_birth=? WHERE user_id=?");
            $stmt->bind_param("ssssi", $phone_number, $location, $address, $date_of_birth, $user_id);
        }
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new profile
        $stmt = $con->prepare("INSERT INTO user_profile (user_id, phone_number, location, address, date_of_birth, profile_picture) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $phone_number, $location, $address, $date_of_birth, $profile_picture);
        $stmt->execute();
        $stmt->close();
    }

    $_SESSION['profile_message'] = "Profile updated successfully.";
    header("Location: profile.php");
    exit;
} else {
    // Form not submitted
    header("Location: profile.php");
    exit;
}
?>
