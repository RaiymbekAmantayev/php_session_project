<?php
global $pdo;
require_once "./db/connect.php";
session_start();
$user = $_SESSION["login"];
$service = $pdo->prepare("SELECT f.*, p.title, p.price, p.image, u.login FROM favorities f INNER JOIN products p ON f.productID = p.id INNER JOIN users u ON f.userID = u.id WHERE u.login = :user_login ORDER BY f.id DESC;");

$service->bindParam(':user_login', $user, PDO::PARAM_STR);
$service->execute();
$res_serv = $service->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Requests</title>
    <link rel="stylesheet" href="/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
<?php
require "head-footer/header_user.php";
?>
<h1 style="text-align: center">Избранные</h1>
<div class="request">
    <?php foreach($res_serv as $serv): ?>
        <div class="card h-100">
            <div class="card-body">
                <a class="black-link" href="/detail.php?id=<?php echo $serv->productID; ?>" >
                    <img src="admin/realising/images/<?php echo $serv->image; ?>" alt="...">
                    <h5 class="card-title">title: <?php echo $serv->title; ?></h5>
                    <br>
                    <h5 class="card-title">price: <?php echo $serv->price; ?></h5>
                    <br>
                </a>
                <form action="admin/realising/fav.php" method="post" name="delFav">
                    <input type="hidden" name="id" value="<?php echo $serv->id; ?>">
                    <button class="btn btn-primary" type="submit" name="del">delete</button>
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
        padding: 20px;
        background-color: #f2f2f2;
    }
    .request {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Отображение по три карточки в строке */
        gap: 20px; /* Отступ между карточками */
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: white;
    }
    .card {
        background-color: snow;
        border-radius: 10px;
    }
    .card-body {
        padding: 20px;
    }
    .card-body img {
        height: auto;
        width: 25%;
        border-radius: 10%;
    }
    .card-title {
        margin-top: 0;
        font-size: 18px;
        color: #333;
    }
    .black-link {
        color: black;
        text-decoration: none;
    }
</style>