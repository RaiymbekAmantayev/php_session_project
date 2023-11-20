<?php
$user = "root";
$password = "";
$host = "localhost";
$db = "tourism";
$dbn = "mysql:host=".$host.';dbname='.$db.';charset=utf8';
$pdo = new PDO($dbn, $user, $password);
$pdo->exec("USE $db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $number = isset($_POST["number"]) ? $_POST["number"] : "";

    // SQL-запрос для вставки данных в базу данных
    $query = "INSERT INTO clicks (name, number) VALUES (:name, :number)";
    $statement = $pdo->prepare($query);

    $params = [
        "name" => $name,
        "number" => $number,
    ];
    $statement->execute($params);

    // Перенаправляем после вставки данных
    header("Location: /practice.php");
    exit();
}
?>
