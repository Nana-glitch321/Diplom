<?php
    session_start();
    $title = "Темы - PodcasterPro"; 
    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="ru">
    <?php include '../php/page_templates/head.php'; ?>
    <body>
        <?php include '../php/page_templates/header.php'; ?>
        <?php include '../php/page_templates/auth.php'; ?>

        <main>
            <?php include '../index/index_theme.html' ?>
        </main>

        <script src="../js/script_login_register.js"></script>
        <script src="../js/check_account.js"></script>


        <style> 
            <?php include '../css/style_theme.css' ?>
            <?php include '../css/page_template_styles/style_header.css' ?>
            <?php include '../css/page_template_styles/style_auth.css' ?>
        </style>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
