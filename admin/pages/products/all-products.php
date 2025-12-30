<?php
$page = 'products';
include __DIR__ . '/../../../config/database.php';

// HANDLE DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Remove image if exists
    $stmt_img = $con->prepare("SELECT image FROM products WHERE id=?");
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $res_img = $stmt_img->get_result();
    if ($res_img->num_rows > 0) {
        $row_img = $res_img->fetch_assoc();
        if (!empty($row_img['image']) && file_exists('../../uploads/' . $row_img['image'])) {
            unlink('../../uploads/' . $row_img['image']);
        }
    }

    // Delete from DB
    $stmt_del = $con->prepare("DELETE FROM products WHERE id=?");
    $stmt_del->bind_param("i", $id);
    $stmt_del->execute();

    header("Location: all-products.php");
    exit;
}

// HANDLE EDIT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = intval($_POST['edit_id']);
    $name = $_POST['name'];
    $description = $_POST['description']; // FIXED: capture description
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $old_price = floatval($_POST['old_price']);
    $stock = intval($_POST['stock']);
    $status = intval($_POST['status']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../../uploads/' . $image_name);

        // Delete old image
        $stmt_old = $con->prepare("SELECT image FROM products WHERE id=?");
        $stmt_old->bind_param("i", $id);
        $stmt_old->execute();
        $res_old = $stmt_old->get_result();
        if ($res_old->num_rows > 0) {
            $row_old = $res_old->fetch_assoc();
            if (!empty($row_old['image']) && file_exists('../../uploads/' . $row_old['image'])) {
                unlink('../../uploads/' . $row_old['image']);
            }
        }

        // Update with new image
        $stmt = $con->prepare("UPDATE products SET name=?, description=?, category_id=?, price=?, old_price=?, stock=?, status=?, image=? WHERE id=?");
        $stmt->bind_param("ssidiisii", $name, $description, $category_id, $price, $old_price, $stock, $status, $image_name, $id);
    } else {
        // Update without changing image
        $stmt = $con->prepare("UPDATE products SET name=?, description=?, category_id=?, price=?, old_price=?, stock=?, status=? WHERE id=?");
        $stmt->bind_param("ssidiisi", $name, $description, $category_id, $price, $old_price, $stock, $status, $id);
    }

    $stmt->execute();
    header("Location: all-products.php");
    exit;
}

include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/navbar.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row mb-4">
            <div class="col-sm-12 d-flex justify-content-between align-items-center">
                <h4 class="font-weight-bold text-dark">All Products</h4>
                <a href="add-product.php" class="btn btn-warning"><i class="fas fa-plus"></i> Add Product</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Old Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th width="200">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $con->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC");
                                $i = 1;
                                while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td><?= number_format($row['price'],2) ?></td>
                                    <td><?= number_format($row['old_price'],2) ?></td>
                                    <td><?= intval($row['stock']) ?></td>
                                    <td class="text-center">
                                        <?= $row['status']==1 
                                            ? '<span class="badge bg-success">Active</span>' 
                                            : '<span class="badge bg-danger">Inactive</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if(!empty($row['image']) && file_exists('../../uploads/'.$row['image'])): ?>
                                            <img src="../../uploads/<?= $row['image'] ?>" width="50" class="rounded" alt="Product Image">
                                        <?php else: ?>
                                            <span class="text-muted">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <!-- Edit Modal Trigger -->
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- View Modal Trigger -->
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?= $row['id'] ?>" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Delete Modal Trigger -->
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow-lg border-0">
                                                    <div class="modal-header bg-dark text-white">
                                                        <h5 class="modal-title" id="editModalLabel<?= $row['id'] ?>">Edit Product</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" enctype="multipart/form-data">
                                                            <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
                                                            <div class="mb-3">
                                                                <label>Name</label>
                                                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Description</label>
                                                                <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($row['description']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Category</label>
                                                                <select name="category_id" class="form-control" required>
                                                                    <?php
                                                                    $cats = $con->query("SELECT id, name FROM categories");
                                                                    while($cat=$cats->fetch_assoc()):
                                                                    ?>
                                                                        <option value="<?= $cat['id'] ?>" <?= $cat['id']==$row['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                                                                    <?php endwhile; ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Price</label>
                                                                <input type="number" step="0.01" name="price" class="form-control" value="<?= $row['price'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Old Price</label>
                                                                <input type="number" step="0.01" name="old_price" class="form-control" value="<?= $row['old_price'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Stock</label>
                                                                <input type="number" name="stock" class="form-control" value="<?= $row['stock'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Status</label>
                                                                <select name="status" class="form-control">
                                                                    <option value="1" <?= $row['status']==1?'selected':'' ?>>Active</option>
                                                                    <option value="0" <?= $row['status']==0?'selected':'' ?>>Inactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label>Image</label>
                                                                <input type="file" name="image" class="form-control">
                                                            </div>
                                                            <button type="submit" class="btn btn-warning w-100"><i class="fas fa-save"></i> Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content shadow-lg border-0">
                                                    <div class="modal-header bg-info text-white">
                                                        <h5 class="modal-title" id="viewModalLabel<?= $row['id'] ?>">Product Details</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
                                                        <p><strong>Category:</strong> <?= htmlspecialchars($row['category_name']) ?></p>
                                                        <p><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
                                                        <p><strong>Price:</strong> ৳<?= number_format($row['price'],2) ?></p>
                                                        <p><strong>Old Price:</strong> ৳<?= number_format($row['old_price'],2) ?></p>
                                                        <p><strong>Stock:</strong> <?= intval($row['stock']) ?></p>
                                                        <p><strong>Status:</strong> <?= $row['status']==1 ? 'Active':'Inactive' ?></p>
                                                        <p><strong>Image:</strong><br>
                                                        <?php if(!empty($row['image']) && file_exists('../../uploads/'.$row['image'])): ?>
                                                            <img src="../../uploads/<?= $row['image'] ?>" width="100" class="rounded">
                                                        <?php else: ?>
                                                            <span class="text-muted">No image</span>
                                                        <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <div class="modal-content shadow border-0">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $row['id'] ?>">Confirm Delete</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        Are you sure you want to delete <strong><?= htmlspecialchars($row['name']) ?></strong>?
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                        <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if($result->num_rows==0): ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">No products found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
