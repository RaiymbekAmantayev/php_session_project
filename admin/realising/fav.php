<?php
global $pdo;
require_once "../db/connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_fav'])) {
        $login = $_SESSION['login'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $ProdId = isset($_POST["response_id"]) ? $_POST["response_id"] : "";
        $userId = $user['id'];
        $checkResponseQuery = "SELECT * FROM favorities WHERE userID = :userID AND productID = :productID";
        $checkResponseStmt = $pdo->prepare($checkResponseQuery);
        $checkResponseStmt->execute([':userID' => $userId, ':productID' => $ProdId]);
        $existingResponse = $checkResponseStmt->fetch(PDO::FETCH_ASSOC);


        if ($userId && !$existingResponse) {
            $query = "INSERT INTO favorities (userID, productID) VALUES (:userID, :productID)";
            $statement = $pdo->prepare($query);

            $params = [
                "userID" => $userId,
                "productID" => $ProdId,
            ];
            $statement->execute($params);

            header("Location: /index.php");
            exit();
        } else {
            header("Location: /index.php");
            exit();;
        }
    }else if (isset($_POST['del'])){
        $id = $_POST['id'];
        // SQL-запрос на удаление записи из таблицы
        $sql = "DELETE FROM favorities WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        // После удаления перенаправьте пользователя или выполните другие действия
        header("Location: /");
        exit();
    }
}
?>