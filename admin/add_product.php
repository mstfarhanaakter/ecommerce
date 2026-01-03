<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) header("Location: login.php");
require '../includes/db.php';

if ($_POST) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
    }

    $stmt = $pdo->prepare("INSERT INTO products (name, category_id, price, stock, image, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $category_id, $price, $stock, $image, $description]);
    header("Location: index.php");
}

$cats = $pdo->query("SELECT * FROM categories")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Add Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Add New Product</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Product Name" required></div>
        <div class="mb-3">
            <select name="category_id" class="form-select" required>
                <?php foreach ($cats as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3"><input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required></div>
        <div class="mb-3"><input type="number" name="stock" class="form-control" placeholder="Stock Quantity" required></div>
        <div class="mb-3"><textarea name="description" class="form-control" placeholder="Description"></textarea></div>
        <div class="mb-3"><input type="file" name="image" class="form-control" accept="image/*"></div>
        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>