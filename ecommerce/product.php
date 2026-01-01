<?php 
require 'includes/db.php';
require 'includes/functions.php';
if (!isset($_GET['id'])) redirect('index.php');
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) redirect('index.php');

if (isset($_POST['add_to_cart'])) {
    if (!is_logged_in()) redirect('login.php');
    $qty = max(1, (int)$_POST['quantity']);
    if (add_to_cart($id, $qty)) {
        echo "<script>alert('Added to cart!');</script>";
    } else {
        echo "<script>alert('Not enough stock!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">My Shop</a>
            <a href="cart.php" class="btn btn-primary">Back to Cart</a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php if ($product['image']): ?>
                    <img src="uploads/<?= htmlspecialchars($product['image']) ?>" class="img-fluid">
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p><strong>Price:</strong> ৳<?= number_format($product['price'], 2) ?></p>
                <p><strong>Stock:</strong> <?= $product['stock'] ?> 
                    <?php if ($product['stock'] <= 0): ?><span class="text-danger">Out of Stock</span><?php endif; ?>
                </p>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>

                <?php if ($product['stock'] > 0): ?>
                    <?php if (is_logged_in()): ?>
                        <form method="post">
                            <div class="mb-3">
                                <label>Quantity:</label>
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="form-control w-25">
                            </div>
                            <button type="submit" name="add_to_cart" class="btn btn-success">Add to Cart</button>
                        </form>
                    <?php else: ?>
                        <p><a href="login.php" class="btn btn-primary">Login to Buy</a></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-danger fs-4">Out of Stock</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>