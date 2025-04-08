<?php
    require '../php/database/db.php'; // Подключение к БД

    header('Content-Type: application/json');

    if (!$conn) {
        echo json_encode(["error" => "Ошибка соединения с базой данных"]);
        exit;
    }

    $result = $conn->query("SELECT id, name FROM genres");

    if (!$result) {
        echo json_encode(["error" => "Ошибка выполнения запроса: " . $conn->error]);
        exit;
    }

    $genres = [];
    while ($row = $result->fetch_assoc()) {
        $genres[] = $row;
    }

    echo json_encode($genres);
?>
