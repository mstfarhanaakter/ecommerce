<?php
$page = 'wishlist';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/topbar.php';
include __DIR__ . '/../includes/navbar.php';

// Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "users/login.php");
    exit;
}

// Fetch user's wishlist products
$user_id = $_SESSION['user_id'];
$wishlistProducts = [];
$stmt = $con->prepare("
    SELECT p.id, p.name, p.image, p.price, p.old_price, p.stock
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = ? AND p.status = 1
    ORDER BY w.id DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$wishlistProducts = $stmt->get_result();
?>

<section class="py-16 bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Title -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">My Wishlist</h1>
            <p class="text-lg text-gray-600 leading-relaxed">
                Here are all the products you’ve saved for later. Add them to your cart whenever you’re ready!
            </p>
        </div>

        <?php if ($wishlistProducts && $wishlistProducts->num_rows > 0): ?>
            <div class="flex flex-col gap-4">
                <?php while($p = $wishlistProducts->fetch_assoc()): ?>
                    <div id="wishlist-item-<?= $p['id'] ?>" class="flex items-center justify-between bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                        
                        <!-- Product -->
                        <div class="flex items-center gap-4">
                            <img src="../admin/uploads/<?= htmlspecialchars($p['image']) ?>" 
                                 alt="<?= htmlspecialchars($p['name']) ?>" 
                                 class="w-24 h-24 object-cover rounded-lg">
                            <div>
                                <h3 class="font-semibold text-lg"><?= htmlspecialchars($p['name']) ?></h3>
                                <span class="text-red-500 font-bold text-lg">৳<?= htmlspecialchars($p['price']) ?></span>
                                <?php if ($p['old_price'] > 0): ?>
                                    <span class="text-gray-400 line-through text-sm">৳<?= htmlspecialchars($p['old_price']) ?></span>
                                <?php endif; ?>
                                <div class="text-green-600 font-semibold">Stock: <?= htmlspecialchars($p['stock']) ?></div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2">
                            <button 
                                onclick="handleAddToCart(<?= $p['id'] ?>)"
                                class="bg-yellow-400 text-black font-bold py-2 px-4 rounded hover:bg-yellow-300">
                                Add to Cart
                            </button>
                            <button
                                onclick="handleRemoveFromWishlist(<?= $p['id'] ?>)"
                                class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded hover:bg-gray-300">
                                Remove
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 text-lg w-full">
                Your wishlist is empty. Browse products and add them here!
            </p>
        <?php endif; ?>

    </div>
</section>


<!-- Tailwind CSS utilities -->
<style>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>


<script>
// Add to Cart: redirect to login if not logged in
function handleAddToCart(id) {
    <?php if (!isset($_SESSION['user_id'])): ?>
        window.location.href = "<?= BASE_URL ?>users/login.php";
        return;
    <?php else: ?>
        // Normal AJAX Add to Cart
        fetch("<?= BASE_URL ?>pages/ajax/add_to_cart.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "product_id=" + id
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Product added to cart!');
                const cartCount = document.getElementById('cart-count');
                if (cartCount) cartCount.innerText = parseInt(cartCount.innerText) + 1;
            } else if (data.status === 'login') {
                window.location.href = "<?= BASE_URL ?>users/login.php";
            } else {
                alert(data.message || 'Something went wrong!');
            }
        });
    <?php endif; ?>
}

// Remove from Wishlist
function handleRemoveFromWishlist(id) {
    fetch("<?= BASE_URL ?>pages/ajax/remove_from_wishlist.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "product_id=" + id
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            const el = document.getElementById('wishlist-item-' + id);
            if (el) el.remove();

            const wishlistCount = document.getElementById('wishlist-count');
            if (wishlistCount) wishlistCount.innerText = parseInt(wishlistCount.innerText) - 1;
        } else if (data.status === 'login') {
            window.location.href = "<?= BASE_URL ?>users/login.php";
        } else {
            alert(data.message || 'Something went wrong!');
        }
    });
}
</script>

<?php 
include __DIR__ . '/../includes/footer.php';
?>
