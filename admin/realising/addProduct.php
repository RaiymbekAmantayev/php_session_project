<?php
global $pdo;
require_once "../db/connect.php";?>
<?php session_start(); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        echo "Файл ". basename($_FILES["image"]["name"]). " успешно загружен.";
    } else {
        echo "Ошибка загрузки файла.";
    }

    // Сохранить данные в базе данных
    $service = "INSERT INTO products (title, price, image, description) VALUES (:title, :price, :image,:description)";
    $serv = $pdo->prepare($service);

    $params = [
        ":title" => $title,
        ":price" => $price,
        "image" => basename($_FILES["image"]["name"]),
        ":description"=>$description,
    ];

    $serv->execute($params);

    header("Location: /admin/addProduct.php");
    exit();
}
?>

