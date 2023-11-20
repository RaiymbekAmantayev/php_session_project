<?php global $pdo;
require_once "../functions/connect.php";  ?>
<?php session_start(); ?>
<?php

// Получение данных из формы
$name = $_POST['name'];
$login = $_POST['login'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Проверка на совпадение паролей
if ($password !== $confirm_password) {
    echo "Пароли не совпадают";
} else {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // SQL-запрос для вставки данных в базу данных
    $query = "INSERT INTO users (name, login, password) VALUES (:name, :login, :password)";
    $statement = $pdo->prepare($query);

    // Выполнение запроса с защитой от SQL-инъекций
    $result = $statement->execute([
        ':name' => $name,
        ':login' => $login,
        ':password' => $hashed_password
    ]);

    if ($result) {
        echo "Пользователь успешно зарегистрирован";
        header('Location:/practice.php');
    } else {
        echo "Ошибка при регистрации пользователя";
    }
}
?>
