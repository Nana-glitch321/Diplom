<?php
session_start();
require_once 'database/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    $user_id = $_SESSION['user_id'];
    $podcast_id = $_POST['podcast_id']; // Исправлено имя параметра

    // Проверка принадлежности подкаста
    $sql = "DELETE FROM podcast WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Ошибка подготовки запроса: " . $conn->error);
    }
    
    // Исправлено: $podcast_id вместо $id
    $stmt->bind_param("ii", $podcast_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Подкаст успешно удален!";
    } else {
        $_SESSION['error'] = "Ошибка: Подкаст не найден или нет прав!";
    }

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header("Location: delete_podcast.php");
exit;