<?php
global $pdo;
require_once "../db/connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_order'])) {
        $login = $_SESSION['login'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $ProdId = isset($_POST["productID"]) ? $_POST["productID"] : "";
        $address = isset($_POST["address"]) ? $_POST["address"] : "";
        $size = isset($_POST["size"]) ? $_POST["size"] : "";
        $counts = isset($_POST["counts"]) ? $_POST["counts"] : "";
        $price = isset($_POST["price"]) ? $_POST["price"] : "";
        $warning = isset($_POST["warning"]) ? $_POST["warning"] : "";
        $total_price = $price * $counts;


        $userId = $user['id'];
        $checkResponseQuery = "SELECT * FROM orders WHERE userID = :userID AND productID = :productID";
        $checkResponseStmt = $pdo->prepare($checkResponseQuery);
        $checkResponseStmt->execute([':userID' => $userId, ':productID' => $ProdId]);
        $existingOrder = $checkResponseStmt->fetch(PDO::FETCH_ASSOC);


        if ($userId && !$existingOrder) {
            $query = "INSERT INTO orders (userID, productID, address, size, counts, total_price, warning) VALUES (:userID, :productID, :address, :size, :counts, :total_price, :warning)";

            $statement = $pdo->prepare($query);

            $params = [
                "userID" => $userId,
                "productID" => $ProdId,
                "address"=>$address,
                "size"=>$size,
                "counts"=>$counts,
                "total_price"=>$total_price,
                "warning"=>$warning,
            ];
            $statement->execute($params);

            header("Location: /");
            exit();
        } else {
            header("Location: /");
            exit();;
        }
    }else if (isset($_POST['delete_order'])){
        $id = $_POST['id'];
        // SQL-запрос на удаление записи из таблицы
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        header("Location: /");
        exit();
    }
}
?>