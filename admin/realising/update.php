<?php
global $pdo;
require_once "../db/connect.php";?>
<?php session_start(); ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST["id"]) ? $_POST["id"] : "";
    $title = isset($_POST["title"]) ? $_POST["title"] : "";
    $price = isset($_POST["price"]) ? $_POST["price"] : "";
    $description = isset($_POST["desc"]) ? $_POST["desc"] : "";
    // Обработка загруженного файла
    $targetDir = "images/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Проверка, является ли файл изображением
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "Файл является изображением - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Файл не является изображением.";
            $uploadOk = 0;
        }
    }

    // Переместить файл в указанное место
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        echo "Файл " . basename($_FILES["image"]["name"]) . " успешно загружен.";
    } else {
        echo "Ошибка загрузки файла.";
    }
    $updateService = $pdo->prepare("UPDATE products SET title = :title, price = :price, image = :image, description = :description WHERE id = :id");
    $updateService->execute([
        ':title' => $title,
        ':price' => $price,
        ':image' => basename($_FILES["image"]["name"]),
        ':description' => $description,
        ':id' => $id
    ]);

    header("Location: /");
    exit();
}
?>