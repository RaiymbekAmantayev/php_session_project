<?php global $pdo;
require_once "../db/connect.php";  ?>
<?php session_start(); ?>
<?php

// Получение данных из формы
$login = $_POST['login'];
$number = $_POST['number'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Проверка на совпадение паролей
if ($password !== $confirm_password) {
    echo "Пароли не совпадают";
} else {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // SQL-запрос для вставки данных в базу данных
    $query = "INSERT INTO users (login,number, password) VALUES (:login,:number, :password)";
    $statement = $pdo->prepare($query);

    // Выполнение запроса с защитой от SQL-инъекций
    $result = $statement->execute([
        ':login' => $login,
        ':number'=>$number,
        ':password' => $hashed_password
    ]);

    if ($result) {
        echo "Пользователь успешно зарегистрирован";
        header('Location: /');
    } else {
        echo "Ошибка при регистрации пользователя";
    }
}
?>