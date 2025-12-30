<?php
$page = 'Users';
include __DIR__ . '/../../../config/database.php';

/* DELETE USER (ONLY role = user) */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $con->prepare("DELETE FROM users WHERE id = ? AND role = 'user'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: users.php");
    exit;
}

/* Include layout AFTER logic */
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/navbar.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-sm-12">
                <h4 class="font-weight-bold text-dark">Registered Users</h4>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white font-weight-bold">
                        User Account List
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover table-striped mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $result = $con->query("
                                    SELECT id, first_name, last_name, email, status, created_at
                                    FROM users
                                    WHERE role = 'user'
                                    ORDER BY id DESC
                                ");

                                $i = 1;
                                while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td class="text-center">
                                        <?= $row['status'] == 0
                                            ? '<span class="badge badge-success">Active</span>'
                                            : '<span class="badge badge-danger">Inactive</span>' ?>
                                    </td>
                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                    <td class="text-center">

                                        <!-- Delete Button -->
                                        <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteUser<?= $row['id'] ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteUser<?= $row['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button"
                                                            class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <p>Are you sure you want to delete?</p>
                                                        <strong><?= htmlspecialchars($row['email']) ?></strong>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <a href="?delete=<?= $row['id'] ?>"
                                                            class="btn btn-danger btn-sm">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php endwhile; ?>

                                <?php if ($result->num_rows == 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No users found.
                                    </td>
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
