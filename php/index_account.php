<?php
    session_start();    
    $title = "Страница пользователя - PodcasterPro"; 
    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
?>

    <!DOCTYPE html>
    <html lang="ru">
    <?php include '../php/page_templates/head.php'; ?>
    <body>
        <?php include '../php/page_templates/header.php'; ?>

        <main>
            <?php include '../index/index_account.html' ?>
            <?php include '../php/page_templates/auth.php'; ?>
        </main>

        <script src="../js/check_account.js"></script>
        <script src="../js/script_login_register.js"></script>
        <style> 
            <?php include '../css/style_account.css' ?>
            <?php include '../css/page_template_styles/style_header.css' ?>
            <?php include '../css/page_template_styles/style_auth.css' ?>
        </style>
    </body>
</html>