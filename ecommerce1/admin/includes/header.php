<?php
// includes/header.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light"> <!-- light/dark theme সাপোর্ট করতে চাইলে -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?= $page_title ?? 'Dashboard' ?></title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
        }
        .sidebar {
            min-height: 100vh;
            transition: width 0.3s ease;
        }
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width) !important;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.85);
            transition: all 0.25s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,.15);
        }
        main {
            transition: margin-left 0.3s ease;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                z-index: 1030;
                width: var(--sidebar-width);
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            main {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-light">

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <a class="navbar-brand fw-bold" href="dashboard.php">Admin Panel</a>
        
        <div class="ms-auto">
            <button class="btn btn-outline-light btn-sm d-none d-lg-inline" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <a href="../logout.php" class="btn btn-outline-danger btn-sm ms-2">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<!-- Space for fixed navbar -->
<div style="height: 56px;"></div>