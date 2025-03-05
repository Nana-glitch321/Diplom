<?php
session_start();
require '../php/database/db.php';

// Получаем данные из запроса
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Не передан ID подкаста']);
    exit;
}

$podcastId = intval($data['id']);
$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;  // Проверка на наличие user_id в сессии

// Проверяем, есть ли уже этот подкаст в избранном
$stmt = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND podcast_id = ?");
$stmt->bind_param("ii", $userId, $podcastId);  // Привязываем параметры
$stmt->execute();
$favorite = $stmt->get_result()->fetch_assoc();  // Получаем результат

if ($favorite) {
    // Если подкаст уже в избранном, удаляем его
    $stmt->close();  // Закрываем текущий запрос перед выполнением следующего

    $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND podcast_id = ?");
    $stmt->bind_param("ii", $userId, $podcastId);  // Привязываем параметры
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'removed' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при удалении из избранного']);
    }
} else {
    // Если подкаста нет в избранном, добавляем его
    $stmt->close();  // Закрываем текущий запрос перед выполнением следующего

    $stmt = $conn->prepare("INSERT INTO favorites (user_id, podcast_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $podcastId);  // Привязываем параметры
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'added' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при добавлении в избранное']);
    }
}
?>
