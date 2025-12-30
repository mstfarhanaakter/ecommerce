<?php
$page = 'categories';
include __DIR__ . '/../../../config/database.php';

/* ADD CATEGORY */
if (isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    $status = ($_POST['status'] == '1') ? 1 : 0; 
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    if (empty($name)) {
        $error = "Category name cannot be empty!";
    } else {
        $stmt_check = $con->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt_check->bind_param("s", $name);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            $error = "Category already exists!";
        } else {
            $stmt = $con->prepare("INSERT INTO categories (name, slug, status) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $name, $slug, $status);
            if ($stmt->execute()) {
                header("Location: categories.php");
                exit;
            } else {
                $error = "Database error: " . $stmt->error;
            }
        }
    }
}

/* UPDATE CATEGORY */
if (isset($_POST['update_category'])) {
    $id = intval($_POST['category_id']);
    $name = trim($_POST['name']);
    $status = ($_POST['status'] == '1') ? 1 : 0; 
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    if (!empty($name)) {
        $stmt = $con->prepare("UPDATE categories SET name=?, slug=?, status=? WHERE id=?");
        $stmt->bind_param("ssii", $name, $slug, $status, $id);
        $stmt->execute();
        header("Location: categories.php");
        exit;
    } else {
        $error = "Category name cannot be empty!";
    }
}

/* DELETE CATEGORY */
if (isset($_POST['delete_category'])) {
    $id = intval($_POST['delete_id']);
    $stmt = $con->prepare("DELETE FROM categories WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: categories.php");
    exit;
}

// Include layout files
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/navbar.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-sm-12">
                <h4 class="font-weight-bold text-dark">Categories</h4>
            </div>
        </div>

        <div class="row">
            <!-- ADD CATEGORY FORM -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white font-weight-bold">
                        Add Category
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" name="add_category" class="btn btn-warning btn-block">
                                Add Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- CATEGORY LIST TABLE -->
            <div class="col-lg-8 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white font-weight-bold">
                        Category List
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th width="140">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $con->query("SELECT * FROM categories ORDER BY id DESC");
                                $i = 1;
                                while ($row = $result->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['slug']) ?></td>
                                        <td class="text-center">
                                            <?= $row['status'] == 1
                                                ? '<span class="badge badge-success">Active</span>'
                                                : '<span class="badge badge-danger">Inactive</span>' ?>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                  &nbsp;
                                                  &nbsp;
                                                <!-- Delete Button -->
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content shadow-lg border-0">
                                                        <div class="modal-header bg-dark text-white">
                                                            <h5 class="modal-title" id="editModalLabel<?= $row['id'] ?>">Edit Category</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST">
                                                                <input type="hidden" name="category_id" value="<?= $row['id'] ?>">
                                                                <div class="form-group mb-3">
                                                                    <label>Name</label>
                                                                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($row['name']) ?>" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label>Status</label>
                                                                    <select name="status" class="form-control">
                                                                        <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                                        <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" name="update_category" class="btn btn-warning w-100 fw-bold">
                                                                    <i class="fas fa-save"></i> Update
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                                    <div class="modal-content shadow-lg border-0">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="deleteModalLabel<?= $row['id'] ?>">Confirm Delete</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <p>Are you sure you want to delete:</p>
                                                            <h6 class="text-bold text-dark"><?= htmlspecialchars($row['name']) ?></h6>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                            <form method="POST" style="display:inline;">
                                                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                                                <button type="submit" name="delete_category" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash-alt"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                <?php if ($result->num_rows == 0) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No categories found.</td>
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

<!-- Bootstrap JS (required for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
