<?php
// Начало сессии
session_start();

// Подключение к базе данных через mysqli
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "podcasterpro";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Проверка, если файл был загружен
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
    // Проверяем, что файл был загружен без ошибок
    if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $user_id = $_SESSION['user_id']; // Получаем ID пользователя из сессии

        // Получаем текущий аватар из базы данных
        $sql = "SELECT avatar FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($current_avatar);
        $stmt->fetch();
        $stmt->close();

        // Папка для сохранения аватарок
        $upload_dir = '../uploads/';
        
        // Если текущий аватар существует, удаляем его
        if ($current_avatar && file_exists($upload_dir . $current_avatar)) {
            unlink($upload_dir . $current_avatar); // Удаляем старое изображение
        }

        // Получаем информацию о файле
        $avatar_tmp = $_FILES['avatar']['tmp_name'];
        $avatar_name = $_FILES['avatar']['name'];
        $avatar_extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
        
        // Генерируем уникальное имя для файла
        $avatar_new_name = uniqid() . '.' . $avatar_extension;

        // Путь для сохранения файла
        $upload_file = $upload_dir . $avatar_new_name;

        // Проверяем, существует ли папка
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Перемещаем файл в директорию
        if (move_uploaded_file($avatar_tmp, $upload_file)) {
            // Обновляем информацию о пользователе в базе данных
            $sql = "UPDATE users SET avatar = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $avatar_new_name, $user_id);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "avatar" => $avatar_new_name]); // Возвращаем имя файла
            } else {
                echo json_encode(["status" => "error", "message" => "Ошибка при обновлении данных в базе."]);
            }

            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Ошибка загрузки файла!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Ошибка при загрузке файла."]);
    }
}

// Закрываем соединение с базой данных
$conn->close();
?>
