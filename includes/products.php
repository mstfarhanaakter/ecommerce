<?php
// include __DIR__ . '/../../config/database.php';
// session_start();

/* -------------------------------
   Function: Fetch products by category slug
---------------------------------*/
function getProducts($con, $slug)
{
    $stmt = $con->prepare("
        SELECT p.id, p.name, p.image, p.price, p.old_price, p.description, p.stock
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE c.slug = ? AND p.status = 1
        ORDER BY p.id DESC
    ");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    return $stmt->get_result();
}

/* -------------------------------
   Function: Redirect if not logged in
---------------------------------*/
function go($url)
{
    return isset($_SESSION['user_id']) ? $url : BASE_URL . 'users/login.php';
}


/* -------------------------------
   Function: Render a single product card (Professional)
---------------------------------*/
function productCard($p)
{ ?>
    <div class="flex-none w-64 bg-white rounded-xl shadow-md snap-start hover:shadow-lg transition-shadow duration-300">
        <div class="relative">
            <img src="..../../admin/uploads/<?= htmlspecialchars($p['image']) ?>"
                alt="<?= htmlspecialchars($p['name']) ?>"
                class="w-full h-48 object-cover rounded-t-xl transition-transform duration-300 hover:scale-105">

            <!-- Stock Badge -->
            <span class="absolute top-2 left-2 bg-green-500 text-black text-xs font-semibold px-2 py-1 rounded-full">
                Stock: <?= htmlspecialchars($p['stock']) ?>
            </span>

            <!-- Optional New Badge -->
            <?php if ($p['old_price'] > 0): ?>
                <span class="absolute top-2 right-2 bg-yellow-400 text-black text-xs font-semibold px-2 py-1 rounded-full">
                    New
                </span>
                <button  onclick="handleAddToWishlist(<?= $p['id'] ?>)"
            class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow hover:bg-gray-100 transition">
            <i class="fas fa-heart text-red-500"></i>
        </button>

            <?php endif; ?>
        </div>

        <div class="p-4 flex flex-col justify-between">
            <div>
                <h3 class="font-semibold text-lg mb-1"><?= htmlspecialchars($p['name']) ?></h3>
                <p class="text-gray-600 text-sm mb-2 line-clamp-3"><?= htmlspecialchars($p['description']) ?></p>

                <div class="flex items-center gap-2 mt-2">
                    <span class="font-bold text-red-500">৳<?= htmlspecialchars($p['price']) ?></span>
                    <?php if ($p['old_price'] > 0): ?>
                        <span class="font-bold text-gray-400 line-through text-sm">৳<?= htmlspecialchars($p['old_price']) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-3 flex gap-2">
                <button 
    onclick="handleAddToCart(<?= $p['id'] ?>)"
    class="flex-1 bg-yellow-400 text-black font-bold py-2 rounded-lg hover:bg-yellow-300 transition">
    Add to Cart
</button>


                <a href="<?= go(BASE_URL . 'pages/preview.php?id=' . $p['id']) ?>"
                    class="flex-1 bg-gray-200 text-gray-800 font-bold py-2 rounded-lg hover:bg-gray-300 text-center transition">
                    <i class="fa-regular fa-eye"></i> Preview
                </a>
            </div>
        </div>
    </div>
<?php } ?>

<!-- -------------------------------
   Fetch all active categories from DB
--------------------------------- -->
<?php
$categories = $con->query("SELECT * FROM categories WHERE status=1 ORDER BY name ASC");
$i = 0; // for alternating background
while ($cat = $categories->fetch_assoc()):
    $bg = ($i % 2 == 0) ? 'bg-gray-50' : 'bg-white';
    $i++;
    $products = getProducts($con, $cat['slug']);
?>
    <section class="<?= $bg ?> py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6"><?= htmlspecialchars($cat['name']) ?></h2>
            <div class="flex overflow-x-auto gap-6 snap-x snap-mandatory scrollbar-hide">
                <?php
                if ($products->num_rows > 0) {
                    while ($p = $products->fetch_assoc()) {
                        productCard($p);
                    }
                } else {
                    echo '<p class="text-gray-500">No products found in this category.</p>';
                }
                ?>
            </div>
        </div>
    </section>
<?php endwhile; ?>

<!-- -------------------------------
   Tailwind CSS scrollbar hide
--------------------------------- -->
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Optional: truncate long descriptions neatly */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>