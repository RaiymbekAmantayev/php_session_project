<?php global $pdo;
require_once "../functions/connect.php";  ?>
<?php session_start(); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    // Фильтрация входных данных перед использованием в запросе
    $login = htmlspecialchars($login); // Защита от XSS-атак
    $password = htmlspecialchars($password); // Защита от XSS-атак

    // Подготовленный запрос для выбора данных из базы данных
    $sql = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $sql->execute([':login' => $login]);
    $user = $sql->fetch(PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $hash_input = password_hash($password, PASSWORD_BCRYPT);
    if($user && (password_verify($password, $user['password']))) {
        $_SESSION['login'] = $user['login'];
        header("Location: /practice.php"); // Перенаправление на защищенную страницу
        exit();
    } else {
        echo "wrong password";
        exit();
    }
}
?>

