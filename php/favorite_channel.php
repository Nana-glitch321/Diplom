<?php
session_start();
require_once 'database/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Вы не авторизованы"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$favorite_user_id = $_POST['favorite_user_id'] ?? 0;

if ($favorite_user_id == 0 || $favorite_user_id == $user_id) {
    echo json_encode(["success" => false, "message" => "Некорректный ID пользователя"]);
    exit;
}

// Проверяем, не добавлен ли уже пользователь
$checkSql = "SELECT * FROM favorites WHERE user_id = ? AND favorite_user_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $user_id, $favorite_user_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Уже в избранном"]);
    exit;
}

$checkStmt->close();

// Добавляем в избранное
$sql = "INSERT INTO favorites (user_id, favorite_user_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $favorite_user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Добавлено в избранное"]);
} else {
    echo json_encode(["success" => false, "message" => "Ошибка базы данных"]);
}

$stmt->close();
