<?php
    session_start();
    require_once '../php/database/db.php';

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Пользователь не авторизован']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['podcast_ids']) || !is_array($data['podcast_ids'])) {
        echo json_encode(['success' => false, 'message' => 'Неверные данные']);
        exit;
    }

    $podcastIds = $data['podcast_ids'];
    $placeholders = implode(',', array_fill(0, count($podcastIds), '?'));
    $query = "SELECT podcast_id FROM favorites WHERE user_id = ? AND podcast_id IN ($placeholders)";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Ошибка запроса']);
        exit;
    }

    $types = str_repeat('i', count($podcastIds) + 1);
    $params = array_merge([$user_id], $podcastIds);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $favorites = [];
    while ($row = $result->fetch_assoc()) {
        $favorites[$row['podcast_id']] = true;
    }

    $stmt->close();
    $conn->close();

    echo json_encode(['success' => true, 'userFavorites' => $favorites]);
