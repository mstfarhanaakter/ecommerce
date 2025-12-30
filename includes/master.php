<?php

    $page = 'home';
    include __DIR__ . '../includes/header.php';
    include __DIR__ . '../includes/topbar.php';
    include __DIR__ . '../includes/navbar.php';

    //page-specific includes can go here
    if($page == 'home'){
        include __DIR__ . '../includes/banner.php';
        include __DIR__ . '../includes/feature.php';
        include __DIR__ . '../includes/products.php';
    }

    // You can add other pages content here

    include __DIR__ . '../includes/footer.php';


?>