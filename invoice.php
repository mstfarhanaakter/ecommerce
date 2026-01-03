<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$user_id = $_SESSION['user_id'];

if ($order_id <= 0) {
    redirect('my_orders.php');
}

$stmt = $pdo->prepare("
    SELECT o.*, u.name as customer_name, u.email 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    $_SESSION['error'] = "Invoice not found or access denied.";
    redirect('my_orders.php');
}

$stmt = $pdo->prepare("
    SELECT oi.*, p.name 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();

// Shop details
$shop_name = "DoraMart";
$shop_address = "House #12, Road #5, Dhanmondi, Dhaka-1205";
$shop_phone = "+880 1711-223344";
$shop_email = "support@myshop.com";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= sprintf('%06d', $order_id) ?> | <?= $shop_name ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @page {
            size: A4;
            margin: 10mm 15mm;
        }
        @media print {
            body { margin: 0; background: white !important; }
            .no-print { display: none !important; }
            .header { background: #1e293b !important; color: white !important; }
            .table-head { background: #86efac !important; color: black !important; }
            .grand-total { background: #86efac !important; color: black !important; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-sm">

<div class="max-w-[210mm] mx-auto bg-white shadow-lg print:shadow-none">

    <!-- Header -->
    <div class="header bg-gray-900 text-white p-6 relative">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-br from-green-400 to-green-500 opacity-30 transform -skew-x-12"></div>
        <div class="relative flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold tracking-wider">INVOICE</h1>
                <p class="mt-1 text-green-300"><?= $shop_name ?></p>
            </div>
            <div class="text-right">
                <p class="text-xl font-bold">#<?= sprintf('%06d', $order_id) ?></p>
                <p class="mt-1">Date: <?= date('d M Y', strtotime($order['created_at'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="grid grid-cols-2 gap-8 p-6 bg-gray-50 border-b border-green-500">
        <div>
            <h3 class="font-bold text-green-700 mb-2">INVOICE TO</h3>
            <p class="font-semibold"><?= htmlspecialchars($order['customer_name']) ?></p>
            <p class="text-gray-700 mt-1 whitespace-pre-line text-xs leading-relaxed"><?= htmlspecialchars($order['shipping_address']) ?></p>
            <p class="mt-1 text-gray-700"><?= htmlspecialchars($order['email']) ?></p>
        </div>
        <div class="text-right">
            <h3 class="font-bold text-green-700 mb-2">FROM</h3>
            <p class="font-semibold"><?= $shop_name ?></p>
            <p class="text-gray-700 mt-1 text-xs leading-relaxed"><?= $shop_address ?></p>
            <p class="mt-1 text-gray-700">Phone: <?= $shop_phone ?></p>
            <p class="mt-1 text-gray-700">Email: <?= $shop_email ?></p>
        </div>
    </div>

    <!-- Table -->
    <div class="p-6">
        <table class="w-full border-collapse">
            <thead>
                <tr class="table-head bg-green-300 text-black font-bold">
                    <th class="p-3 text-left w-12">NO</th>
                    <th class="p-3 text-left">PRODUCT DESCRIPTION</th>
                    <th class="p-3 text-right">PRICE</th>
                    <th class="p-3 text-center">QTY</th>
                    <th class="p-3 text-right">TOTAL</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $sl = 1; foreach ($items as $item): ?>
                <tr>
                    <td class="p-3"><?= sprintf('%02d', $sl++) ?></td>
                    <td class="p-3 font-medium"><?= htmlspecialchars($item['name']) ?></td>
                    <td class="p-3 text-right">৳<?= number_format($item['price_at_purchase'], 2) ?></td>
                    <td class="p-3 text-center"><?= $item['quantity'] ?></td>
                    <td class="p-3 text-right font-bold">৳<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="p-6 pt-0 flex justify-end">
        <div class="w-80 space-y-2">
            <?php if ($order['discount'] > 0): ?>
            <div class="flex justify-between text-red-600 text-sm">
                <span>Discount:</span>
                <span>-৳<?= number_format($order['discount'], 2) ?></span>
            </div>
            <?php endif; ?>
            <div class="flex justify-between items-center grand-total bg-green-400 text-black font-bold p-3 rounded">
                <span>Total:</span>
                <span>৳<?= number_format($order['final_total'], 2) ?></span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-900 text-white p-6 text-center text-xs">
        <p>Thank You For Your Business</p>
        <div class="mt-3 flex justify-center gap-6">
            <span><i class="fas fa-phone mr-1"></i><?= $shop_phone ?></span>
            <span><i class="fas fa-envelope mr-1"></i><?= $shop_email ?></span>
            <span><i class="fas fa-map-marker-alt mr-1"></i><?= $shop_address ?></span>
        </div>
    </div>

</div>

<!-- Print Button -->
<div class="text-center my-8 no-print">
    <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-10 py-4 rounded-lg font-bold shadow-lg transition">
        <i class="fas fa-print mr-2"></i> Print Invoice (1 Page)
    </button>
</div>

</body>
</html>