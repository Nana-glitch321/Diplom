<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "podcasterpro";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $type = $_GET['type']; // 'audio' или 'image'

    $column_data = $type . "_data";
    $column_type = $type . "_type";

    $stmt = $conn->prepare("SELECT $column_data, $column_type FROM Podcast WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($fileData, $fileType);
        $stmt->fetch();
        
        header("Content-Type: $fileType");
        header("Accept-Ranges: bytes");

        if ($type === "audio") {
            // Определяем размер файла
            $fileSize = strlen($fileData);
            $range = isset($_SERVER['HTTP_RANGE']) ? $_SERVER['HTTP_RANGE'] : null;

            if ($range) {
                preg_match('/bytes=(\d+)-(\d+)?/', $range, $matches);
                $start = intval($matches[1]);
                $end = isset($matches[2]) ? intval($matches[2]) : ($fileSize - 1);
                
                header("HTTP/1.1 206 Partial Content");
                header("Content-Range: bytes $start-$end/$fileSize");
                header("Content-Length: " . ($end - $start + 1));

                echo substr($fileData, $start, $end - $start + 1);
            } else {
                // Если браузер не запрашивает часть файла, отдаем всё
                header("Content-Length: " . $fileSize);
                echo $fileData;
            }
        } else {
            // Отправляем изображения без `206 Partial Content`
            header("Content-Length: " . strlen($fileData));
            echo $fileData;
        }
    } else {
        http_response_code(404);
        echo "Файл не найден";
    }

    $stmt->close();
}
$conn->close();
?>
