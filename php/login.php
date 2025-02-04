<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    header('Content-Type: application/json');
    require_once '../php/database/db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Неверный пароль"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Пользователь не найден"]);
        }
        $stmt->close();
    }
    $conn->close();
?>
