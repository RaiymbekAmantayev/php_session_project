<?php
global $pdo;
require_once "../functions/connect.php"; // Подключение к базе данных
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST["old"];
    $newPassword = $_POST["new"];

    // Получаем пользователя из базы данных
    $login = $_SESSION['login']; // Предполагается, что вы храните имя пользователя в сессии

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $stmt->execute([':login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Сверяем старый пароль с паролем пользователя в базе данных
        if (password_verify($oldPassword, $user['password'])) {
            // Старый пароль совпадает, хешируем и обновляем пароль на новый
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE login = :login");
            $updateStmt->execute([':password' => $hashedPassword, ':login' => $login]);

            echo json_encode("Success");
        } else {
            echo json_encode(["error" => "Wrong password"]);
        }
    } else {
        echo json_encode(["error" => "User not found"]);
        echo $login;
    }
}
?>
