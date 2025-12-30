

<?php 
$page = 'help';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';    
include __DIR__ . '/../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Help - DoraMart</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-6">Help & Support</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-xl font-semibold mb-3">Need Assistance?</h2>
      <p class="mb-4">If you have any questions or face any issues with our website, feel free to reach out to us. We’re here to help you!</p>

      <ul class="space-y-3">
        <li>
          <i class="fas fa-envelope text-yellow-400 mr-2"></i>
          Email: <a href="mailto:support@doramart.com" class="text-blue-600">support@doramart.com</a>
        </li>
        <li>
          <i class="fas fa-phone text-yellow-400 mr-2"></i>
          Phone: <a href="tel:+1234567890" class="text-blue-600">+1 234 567 890</a>
        </li>
        <li>
          <i class="fas fa-comment-alt text-yellow-400 mr-2"></i>
          Live Chat: Available 24/7 on our website
        </li>
      </ul>
    </div>

    <div class="mt-6 text-center">
      <a href="<?= BASE_URL ?>index1.php" class="btn btn-success font-bold">Back to Home</a>
    </div>
  </div>

</body>
</html>

<?php 
include __DIR__ . '/../includes/footer.php';    
?>
