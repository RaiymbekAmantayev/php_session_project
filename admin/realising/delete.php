<?php
global $pdo;
require_once "../db/connect.php";?>
<?php session_start(); ?>
<?php

// Обработка нажатия кнопки удаления
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Получение ID записи, которую нужно удалить
        $id_to_delete = $_POST['id_to_delete'];
        // SQL-запрос на удаление записи из таблицы
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id_to_delete]);

        // После удаления перенаправьте пользователя или выполните другие действия
        header("Location: /index.php");
        exit();
    }
}
?>