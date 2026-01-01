<?php
$page_title = "Manage Products";
$current_page = "products";

require 'includes/header.php';
require 'includes/sidebar.php';
require '../includes/db.php';

// তোমার পুরানো কোড এখানে
$stmt = $pdo->query("SELECT p.*, c.name as cat_name FROM products p LEFT JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll();
?>

<main class="container-fluid py-4" style="margin-left: var(--sidebar-width);">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Products Management</h2>
        <a href="add_product.php" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Add New Product
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td>
                                <?php if ($p['image']): ?>
                                    <img src="../uploads/<?= htmlspecialchars($p['image']) ?>" alt="" width="60" class="rounded">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-medium"><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= htmlspecialchars($p['cat_name'] ?? '—') ?></td>
                            <td>৳<?= number_format($p['price'], 2) ?></td>
                            <td>
                                <?php if ($p['stock'] <= 0): ?>
                                    <span class="badge bg-danger">Out of Stock</span>
                                <?php else: ?>
                                    <?= $p['stock'] ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php require 'includes/footer.php'; ?>