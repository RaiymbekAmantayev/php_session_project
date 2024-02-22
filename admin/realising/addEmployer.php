<?php
global $pdo;
require_once "../db/connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $job_title = isset($_POST["job_title"]) ? $_POST["job_title"] : "";

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

    // Сохранить данные в базе данных
    $service = "INSERT INTO employees (name, job_title, image) VALUES (:name, :job_title, :image)";
    $serv = $pdo->prepare($service);

    $params = [
        ":name" => $name,
        ":job_title" => $job_title,
        ":image" => basename($_FILES["image"]["name"]),
    ];
    $serv->execute($params);

    header("Location: /admin/addEmployees.php");
    exit();
}
?>
