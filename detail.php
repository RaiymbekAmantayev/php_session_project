<?php
global $pdo;
require_once "./db/connect.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $service = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $service->bindParam(':id', $id);
    $service->execute();

    $res_serv = $service->fetch(PDO::FETCH_OBJ);

    $comments = $pdo->prepare("SELECT c.id, c.text, c.image, p.id as prodId, p.title, p.price, u.login, u.login 
                                FROM comments c 
                                INNER JOIN products p ON c.ProductID = p.id
                                INNER JOIN users u ON c.userID = u.id
                                WHERE p.id = :id
                                order by id desc 
                                LIMIT 6;");

    $comments->execute([
        ':id' => $id
    ]);
    $res_comments = $comments->fetchAll(PDO::FETCH_OBJ);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Детальная информация</title>
</head>
<body>
<?php
require "head-footer/header.php";
?>
<div style="background-color: #abdde5; text-align: center">
    <?php if(isset($res_serv)): ?>
        <h2 style="text-align: center; margin-top: 0%;"><?php echo $res_serv->title ?></h2>
        <img style="width: 25%; border-radius: 10%;" src="admin/realising/images/<?php echo $res_serv->image; ?>" alt="...">
        <p>Цена: <?php echo $res_serv->price; ?></p>
        <p>Описание: <?php echo $res_serv->description; ?></p>
    <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] === "admin") {
        ?>
    <div class="buttons">
        <a href="admin/updateProduct.php?id=<?php echo $res_serv->id; ?>" class="black-link">
            <button class="btn btn-primary ">edit</button>
        </a>
        <form style="text-align: center;" action="admin/realising/delete.php" method="post">
            <input type="hidden" name="id_to_delete" value="<?php echo $res_serv->id; ?>">
            <button type="submit" name="delete" class="btn btn-primary ">delete</button>
        </form>
    </div>
        <?php
        } else if (isset($_SESSION['login']) && $_SESSION['login'] != "admin") {
            ?>
        <div class="buttons">
            <form style="text-align: center;" action="admin/realising/fav.php" method="post" name="add_fav">
                <input type="hidden" name="response_id" value="<?php echo $res_serv->id; ?>">
                <button type="submit" name="add_fav" class="btn btn-primary ">Избранное</button>
            </form>
        </div>
        <div style="padding: 2%">
            <div class="mb-3">
                <form action="admin/realising/addComment.php" method="post" enctype="multipart/form-data">
                    <label for="exampleFormControlTextarea1" class="form-label">Напишите отзыв</label>
                    <input type="hidden" name="id" value="<?php echo $res_serv->id; ?>">
                    <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"></textarea>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*" >
                    <button type="submit" name="send" class="btn btn-primary ">Отправить</button>
                </form>
            </div>
        </div>
    <?php
        }
        ?>
    <?php else: ?>
        <p>Страна не найдена</p>
    <?php endif; ?>
</div>
<?php if (isset($res_comments) && count($res_comments)>0) : ?>

<h2 style="text-align: center;padding: 15px 0 0px;">Комментарии наших клиентов:</h2>
<?php foreach($res_comments as $com):?>
    <div class="request">
        <div style="margin-left: 550px; width: 500px" class="card h-50">
            <div  id="<?php echo $com->id?>" style="padding: 20px;font-size: 20px; text-align: left;" class="card-body">
                <?php if ($com->image !== null): ?>
                <img style=" height: auto; width: 25%; border-radius: 10%;" src="admin/realising/images/<?php echo $com->image; ?>" alt="...">
                <?php endif; ?>
                <h5 class="card-title"><?php echo $com->login?></h5>
                <br>
                <h3 class="card-text"><?php echo $com->text?></h3>
            </div>
            <?php
            if ($_SESSION['login'] === "admin" || $_SESSION['login'] === $com->login) {
            ?>
            <div class="buttons">
            <form action="admin/realising/comments.php" method="post" name="delClick">
                <input type="hidden" name="form_id" value="delete">
                <input type="hidden" name="id" value="<?php echo $com->id; ?>">
                <button style="margin-left: 350px; margin-bottom: 10px" class="btn btn-danger" type="submit" name="del">delete</button>
            </form>
            <?php
            }
?>
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>

<?php if(isset($res_serv) && (isset($_SESSION['login']) && $_SESSION['login'] != "admin")):
?>
    <div class="container mt-4">
        <h2>Форма заказа</h2>
        <form action="admin/realising/orders.php" method="POST">
            <div class="form-group">
                <input type="hidden" class="form-control" id="productID" name="productID" value="<?php echo $res_serv->id; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Адрес:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="size">Размер:</label>
                <input type="text" class="form-control" id="size" name="size" required>
            </div>
            <div class="form-group">
                <label for="counts">Количество:</label>
                <input type="number" class="form-control" id="counts" name="counts" required>
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="price" name="price" value="<?php echo $res_serv->price; ?>" required>
            </div>
            <div class="form-group">
                <label for="warning">Предупреждение:</label>
                <textarea class="form-control" placeholder="здесь вы можете написать все примечании насчет заказа" id="warning" name="warning" rows="3"></textarea>
            </div>
            <button name="add_order" type="submit" class="btn btn-primary">Отправить заказ</button>
        </form>
    </div>
<?php endif; ?>
<?php require "head-footer/footer.php" ?>
</body>
</html>
<style>
    .requests {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .request {
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .request h3 {
        margin-top: 0;
        font-size: 18px;
        color: #333;
    }
    .request p {
        margin: 5px 0;
        font-size: 16px;
    }
</style>