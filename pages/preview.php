<?php
$page = 'product-preview';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/topbar.php';
require_once __DIR__ . '/../includes/navbar.php';

/* ======================================
   1. Validate Request
====================================== */
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$productId) {
    http_response_code(404);
    echo "<div class='py-32 text-center text-gray-500'>Invalid product request.</div>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

/* ======================================
   2. Fetch Product (Secure & Optimized)
====================================== */
$sql = "
    SELECT 
        p.id, p.name, p.image, p.price, p.old_price, 
        p.description, p.stock,
        c.name AS category
    FROM products p
    INNER JOIN categories c ON c.id = p.category_id
    WHERE p.id = ? AND p.status = 1
    LIMIT 1
";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    http_response_code(404);
    echo "<div class='py-32 text-center text-gray-500'>Product not found.</div>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}
?>

<!-- ======================================
     Product Preview Section
====================================== -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">

        <div class="grid lg:grid-cols-2 gap-16 items-start">

            <!-- Product Image -->
            <div class="bg-white rounded-3xl shadow-xl p-6">
                <img 
                    src="../admin/uploads/<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                    class="w-full h-[350px] object-cover rounded-2xl"
                />
            </div>

            <!-- Product Info -->
            <div class="space-y-4">

                <!-- Category -->
                <span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-5 p-1 rounded-full text-sm font-semibold">
                    <?= htmlspecialchars($product['category']) ?>
                </span>

                <!-- Title -->
                <h1 class="text-3xl xl:text-3xl font-extrabold text-gray-900 leading-tight">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>

                <!-- Description -->
                <p class="text-gray-600 text-lg leading-relaxed max-w-xl">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </p>

                <!-- Price -->
                <div class="flex items-center gap-4 ">
                    <span class="text-2xl font-bold text-red-500">
                        ৳<?= number_format($product['price'], 2) ?>
                    </span>

                    <?php if ($product['old_price'] > 0): ?>
                        <span class="text-xl text-gray-400 line-through">
                            ৳<?= number_format($product['old_price'], 2) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Stock -->
                <p class="text-sm text-gray-500">
                    Availability:
                    <span class="font-semibold <?= $product['stock'] > 0 ? 'text-green-600' : 'text-red-500' ?>">
                        <?= $product['stock'] > 0 ? 'In Stock ('.$product['stock'].')' : 'Out of Stock' ?>
                    </span>
                </p>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6">

                    <a 
                        href="<?= BASE_URL.'pages/add-to-cart.php?id='.$product['id'] ?>"
                        class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-400 text-black font-bold px-10 py-4 rounded-xl transition"
                    >
                        🛒 Add to Cart
                    </a>

                    <a 
                        href="<?= BASE_URL ?>"
                        class="inline-flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold px-10 py-4 rounded-xl transition"
                    >
                        ← Continue Shopping
                    </a>

                </div>

            </div>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
