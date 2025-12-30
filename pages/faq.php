
<?php 
$page = 'faq';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ - DoraMart</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-6">Frequently Asked Questions (FAQ)</h1>

    <div class="space-y-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-2">1. How can I place an order?</h2>
        <p>To place an order, browse our products, add items to your cart, and proceed to checkout.</p>
      </div>

      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-2">2. What payment methods do you accept?</h2>
        <p>We accept credit/debit cards, PayPal, and other secure online payments.</p>
      </div>

      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-2">3. Can I track my order?</h2>
        <p>Yes! Once your order is shipped, you’ll receive a tracking number to monitor delivery status.</p>
      </div>

      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-2">4. How can I contact customer support?</h2>
        <p>You can contact us via email, phone, or live chat. Check our <a href="<?= BASE_URL ?>help.php" class="text-blue-600">Help page</a> for details.</p>
      </div>
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
