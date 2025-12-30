<?php
$page = 'cart';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';

$user_id = $_SESSION['user_id'] ?? 0;
$cartProducts = [];

if ($user_id) {
    $stmt = $con->prepare("
        SELECT p.id, p.name, p.image, p.price, p.old_price, p.stock, c.quantity
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ? AND p.status = 1
        ORDER BY c.id DESC
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cartProducts = $stmt->get_result();
}
?>

<section class="py-16 bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Title -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                My Cart
            </h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Review your cart, update quantities, or remove items before checkout.
            </p>
        </div>

        <?php if ($cartProducts && $cartProducts->num_rows > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Price</th>
                        <th class="px-4 py-2 text-left">Quantity</th>
                        <th class="px-4 py-2 text-left">Stock</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($p = $cartProducts->fetch_assoc()): ?>
                    <tr id="cart-item-<?= $p['id'] ?>" class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 flex items-center gap-4">
                            <img src="../admin/uploads/<?= htmlspecialchars($p['image']) ?>" 
                                 alt="<?= htmlspecialchars($p['name']) ?>" class="w-20 h-20 object-cover rounded-lg">
                            <span class="font-semibold"><?= htmlspecialchars($p['name']) ?></span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-red-500 font-bold">৳<?= htmlspecialchars($p['price']) ?></span>
                            <?php if ($p['old_price'] > 0): ?>
                                <span class="text-gray-400 line-through text-sm">৳<?= htmlspecialchars($p['old_price']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <button onclick="updateQuantity(<?= $p['id'] ?>, -1)" class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 transition">-</button>
                                <input type="text" id="qty-<?= $p['id'] ?>" value="<?= $p['quantity'] ?>" class="w-12 text-center border rounded-lg" readonly>
                                <button onclick="updateQuantity(<?= $p['id'] ?>, 1)" class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 transition">+</button>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-green-600 font-semibold"><?= htmlspecialchars($p['stock']) ?></td>
                        <td class="px-4 py-3">
                            <button onclick="removeFromCart(<?= $p['id'] ?>)" class="bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 transition">
                                Remove
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p class="text-center text-gray-500 text-lg w-full">
                Your cart is empty. Add some products to continue shopping!
            </p>
        <?php endif; ?>
    </div>
</section>


<script>
function removeFromCart(id) {
    fetch("<?= BASE_URL ?>pages/ajax/remove_from_cart.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "product_id=" + id
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            const el = document.getElementById('cart-item-' + id);
            if (el) el.remove();

            const cartCount = document.getElementById('cart-count');
            if (cartCount) cartCount.innerText = data.count;
        } else if (data.status === 'login') {
            window.location.href = "<?= BASE_URL ?>users/login.php";
        } else {
            alert(data.message || 'Something went wrong!');
        }
    });
}

function updateQuantity(id, change) {
    const qtyInput = document.getElementById('qty-' + id);
    let qty = parseInt(qtyInput.value) + change;

    // Remove product if quantity <=0
    if (qty <= 0) {
        removeFromCart(id);
        return;
    }

    fetch("<?= BASE_URL ?>pages/ajax/update_cart.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "product_id=" + id + "&quantity=" + qty
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            qtyInput.value = qty;

            // Update navbar cart count
            const cartCount = document.getElementById('cart-count');
            if (cartCount) cartCount.innerText = data.count;
        } else if (data.status === 'login') {
            window.location.href = "<?= BASE_URL ?>users/login.php";
        } else {
            alert(data.message || 'Something went wrong!');
        }
    });
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<!-- Tailwind CSS utilities -->
<style>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
