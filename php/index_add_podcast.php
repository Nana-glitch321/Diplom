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
        <?php include '../php/page_templates/header.php'; ?>

        <main>
            <?php include '../index/add_podcast.html' ?>
            <?php include '../php/page_templates/auth.php'; ?>
        </main>

        <style> 
            <?php include '../css/add_podcast.css' ?>
            <?php include '../css/page_template_styles/style_header.css' ?>
            <?php include '../css/page_template_styles/style_auth.css' ?>
        </style>
        <script src="../js/script_login_register.js"></script>
        <script src="../js/check_account.js"></script>
    </body>

    