<?php
    session_start();    
    $title = "Страница добавления - PodcasterPro"; 
    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
?>

    <!DOCTYPE html>
    <html lang="ru">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <?php include '../php/page_templates/head.php'; ?>
    <body>

        <main id="page-content">
            <?php include '../index/add_podcast.html' ?>
        </main>
        <?php include '../php/page_templates/header.php'; ?>

        <style> 
            <?php include '../css/add_podcast.css' ?>
            <?php include '../css/page_template_styles/style_header.css' ?>
            <?php include '../css/page_template_styles/style_auth.css' ?>
        </style>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    </body>
</html>