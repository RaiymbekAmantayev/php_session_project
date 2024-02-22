<?php
global $pdo;
require_once "../db/connect.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form_id'])) {
        $form_id = $_POST['form_id'];
        if ($form_id === 'delete') {
            // Получение ID записи, которую нужно удалить
            $id = $_POST['id'];
            // SQL-запрос на удаление записи из таблицы
            $sql = "DELETE FROM comments WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            header("Location: /index.php");
            exit();
        }
    }
}
?>