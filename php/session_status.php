<?php
    session_start();
    header('Content-Type: application/json');
    echo json_encode(['logged_in' => isset($_SESSION['user_id']), 'user_name' => $_SESSION['user_name'] ?? '']);
?>
