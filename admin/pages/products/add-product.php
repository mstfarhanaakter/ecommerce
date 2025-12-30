<?php
$page = 'add-product';
include __DIR__ . '/../../../config/database.php';

$error = '';
$success = '';

if(isset($_POST['add_product'])){
    $name = trim($_POST['name']);
    $category_id = intval($_POST['category_id']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $old_price = floatval($_POST['old_price']);
    $stock = intval($_POST['stock']);
    $status = ($_POST['status']==1)?1:0;
    $image = '';

    if(empty($name)){
        $error = "Product name cannot be empty!";
    } else {
        // Upload directory
        $upload_dir = __DIR__ . '/../../uploads/';
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0755, true);
        }

        // Handle Image Upload
        if(isset($_FILES['image']) && $_FILES['image']['error']==0){
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image = time().rand(1000,9999).'.'.$ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image);
        }

        // Insert into DB
        $stmt = $con->prepare("INSERT INTO products (category_id, name, description, price, old_price, stock, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdiisi", $category_id, $name, $description, $price, $old_price, $stock, $image, $status);

        if($stmt->execute()){
            $success = "Product added successfully!";
        } else {
            $error = "Database error: ".$stmt->error;
        }
    }
}

// Fetch categories
$categories = $con->query("SELECT * FROM categories WHERE status=1 ORDER BY name ASC");

// Include layout
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/navbar.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold">
                    Add New Product
                </div>
                <div class="card-body">

                    <!-- Alerts -->
                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if(!empty($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form method="POST" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="productName">Product Name</label>
                                    <input type="text" id="productName" name="name" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="category">Category</label>
                                    <select id="category" name="category_id" class="form-control" required>
                                        <option value="">-- Select Category --</option>
                                        <?php while($cat=$categories->fetch_assoc()): ?>
                                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" step="0.01" id="price" name="price" class="form-control" min="0" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="oldPrice">Old Price</label>
                                    <input type="number" step="0.01" id="oldPrice" name="old_price" class="form-control" min="0" required>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="1"></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="stock">Stock</label>
                                    <input type="number" id="stock" name="stock" class="form-control" min="0" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" id="image" name="image" class="form-control" accept="image/png, image/jpeg, image/webp">
                                    <small class="form-text text-muted">Allowed formats: PNG, JPG, JPEG, WEBP</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-warning w-100 mt-3">
                            <i class="fas fa-plus"></i> Add Product
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>


<?php include __DIR__ . '/../../includes/footer.php'; ?>
