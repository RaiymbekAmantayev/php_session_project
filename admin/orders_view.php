<?php
global $pdo;
require_once "./db/connect.php";
session_start();
$service = $pdo->prepare("SELECT orders.id, orders.userID, orders.productID, orders.address, orders.size, orders.counts, orders.total_price, orders.warning, users.login AS userName, users.number as phone, products.title AS productName 
        FROM orders 
        INNER JOIN users ON orders.userID = users.id 
        INNER JOIN products ON orders.productID = products.id
        order by id desc;");
$service->execute();
$orders = $service->fetchAll(PDO::FETCH_ASSOC);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/style.css">
    <title>Client Db View</title>
</head>
<body>
<?php require "../head-footer/header_admin.php"; ?>
<h1>Client Db</h1>
<div class="orders-table">
    <table>
        <thead>
        <tr>
            <th>Login</th>
            <th>Phone</th>
            <th>Title</th>
            <th>Address</th>
            <th>Size</th>
            <th>Counts</th>
            <th>Total_Price</th>
            <th>Warning</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order) { ?>
            <tr>
                <td><?php echo $order['userName']; ?></td>
                <td><?php echo $order['phone']; ?></td>
                <td><a href='/detail.php?id=<?php echo $order['productID']; ?>'><?php echo $order['productName']; ?></a></td>
                <td><?php echo $order['address']; ?></td>
                <td><?php echo $order['size']; ?></td>
                <td><?php echo $order['counts']; ?></td>
                <td><?php echo $order['total_price']; ?></td>
                <td><?php echo $order['warning']; ?></td>
                <td>
                    <form action="realising/orders.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>


<style>
    /* Стили для таблицы */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #000;
        color: #fff;
    }

    /* Стили для заголовка */
    h1 {
        text-align: center;
    }

    /* Стили для контейнера таблицы */
    .orders-table {
        margin: auto;
        width: 90%;
    }

    /* Стили для кнопки "Delete" */
    .btn-delete {
        background-color: #dc3545;
        color: #fff;
        font-size: 14px;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #bf2c38;
    }


</style>