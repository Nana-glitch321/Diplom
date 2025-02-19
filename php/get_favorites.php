<?php
    session_start();    

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "podcasterpro";

    // Подключение к базе данных
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверка на подключение
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Получаем идентификатор пользователя (можно передавать через сессию или GET-параметры)
    $user_id = $_SESSION['user_id'];

    // Запрос для получения только избранных подкастов пользователя
    $sql = "
        SELECT p.id, p.title, p.image_data, p.image_type 
        FROM podcast p
        JOIN favorites f ON p.id = f.podcast_id
        WHERE f.user_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);  // Привязываем параметр user_id
    $stmt->execute();
    $result = $stmt->get_result();

    $podcasts = [];

    if ($result->num_rows > 0) {
        // Извлекаем данные о подкастах
        while($row = $result->fetch_assoc()) {
            $podcasts[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'image_data' => base64_encode($row['image_data']),  // Кодируем изображение в base64
                'image_type' => $row['image_type'],  // Тип изображения (например, image/jpeg)
            ];
        }
    } else {
        echo "Нет данных о любимых подкастах";
    }

    $stmt->close();
    $conn->close();

    // Возвращаем данные в формате JSON
    header('Content-Type: application/json');
    echo json_encode(['podcasts' => $podcasts]);
?>
