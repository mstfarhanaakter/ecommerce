<?php
$page = 'sample db page';
include __DIR__ . '/../../../config/database.php';

// Example: handle your PHP logic here (add, edit, delete)

// Include layout AFTER all PHP logic
include __DIR__ . '/../../includes/header.php';
include __DIR__ . '/../../includes/navbar.php';
include __DIR__ . '/../../includes/sidebar.php';
?>

<div class="main-panel">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-sm-12">
                <h4 class="font-weight-bold text-dark"><?= $page ?></h4>
                <p class="text-muted mb-0"></p>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">

           <!-- main content starts here bro  -->
          
             <!-- main content ends here bro  -->
        </div> <!-- end row -->

    </div> <!-- end content-wrapper -->


<?php include __DIR__ . '/../../includes/footer.php'; ?>
