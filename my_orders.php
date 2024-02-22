<?php
global $pdo;
require_once "./db/connect.php";
session_start();
$user = $_SESSION["login"];
$service = $pdo->prepare("SELECT orders.id, 
                   orders.userID, orders.productID, 
                   orders.address, orders.size, orders.counts, 
                   orders.total_price, orders.warning, 
                   products.title,products.image
                    FROM orders 
                    INNER JOIN users ON orders.userID = users.id 
                    INNER JOIN products ON orders.productID = products.id 
                    WHERE users.login= :user_login 
                    order by id desc;");

$service->bindParam(':user_login', $user, PDO::PARAM_STR);
$service->execute();
$res_serv = $service->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Orders</title>
    <link rel="stylesheet" href="/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
<?php
require "head-footer/header_user.php";
?>
<h1 style="text-align: center">My orders</h1>
<div class="request">
    <?php foreach ($res_serv as $serv): ?>
        <div class="card h-100" style="margin-right: 20px;">
            <div style="background-color: #000" class="card-body">
                <a class="black-link" href="/detail.php?id=<?php echo $serv->productID; ?>">
                    <img style=" height: 213px; width: 100%; border-radius: 10%; margin-bottom: 15px;"
                         src="admin/realising/images/<?php echo $serv->image; ?>" alt="...">
                    <h5 class="card-title">title:
                        <?php echo $serv->title ?>
                    </h5>
                    <br>
                    <h5 class="card-title">address:
                        <?php echo $serv->address ?>
                    </h5>
                    <br>
                    <h5 class="card-title">size:
                        <?php echo $serv->size ?>
                    </h5>
                    <br>
                    <h5 class="card-title">count:
                        <?php echo $serv->counts ?>
                    </h5>
                    <br>
                    <h5 class="card-title">total price:
                        <?php echo $serv->total_price ?>
                    </h5>
                    <br>
                </a>
                <form action="admin/realising/orders.php" method="post" name="delete">
                    <input type="hidden" name="id" value="<?php echo $serv->id; ?>">
                    <button class="btn btn-outline-danger" type="submit" name="delete_order">delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require "head-footer/footer.php" ?>
</body>

</html>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
    }

    .navigation {
        margin-bottom: 10px;
    }

    .card-title {
        color: #fff;
    }

    .request {
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .request h3 {
        margin-top: 0;
        font-size: 18px;
        color: #333;
    }

    .footer__content {
        padding: 15px;
    }

    .footer__content-title {
        color: #fff;
    }

    .request p {
        margin: 5px 0;
        font-size: 16px;
    }
</style>