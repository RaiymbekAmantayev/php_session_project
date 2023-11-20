<?php
$user = "root";
$password = "";
$host = "localhost";
$db = "tourism";
$dbn = "mysql:host=".$host.';dbname='.$db.';charset=utf8';
$pdo = new PDO($dbn, $user, $password);
$pdo->exec("USE $db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST["title"]) ? $_POST["title"] : "";
    $price = isset($_POST["price"]) ? $_POST["price"] : "";
    $datastart = isset($_POST["datastart"]) ? $_POST["datastart"] : "";
    $dataend = isset($_POST["dataend"]) ? $_POST["dataend"] : "";

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
    $service = "INSERT INTO tour (title, price, image, datastart, dataend) VALUES (:title, :price, :image,:datastart, :dataend )";
    $serv = $pdo->prepare($service);

    $params = [
        ":title" => $title,
        ":price" => $price,
        "image" => basename($_FILES["image"]["name"]),
        ":datastart"=>$datastart,
        ":dataend"=>$dataend
    ];

    $serv->execute($params);

    header("Location: /admin/addTour.php");
    exit();
}
?>
