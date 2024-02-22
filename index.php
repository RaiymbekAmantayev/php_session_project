<?php global $pdo;
require_once "./db/connect.php"; ?>

<?php
$service = $pdo->prepare("SELECT * FROM products order by id desc LIMIT 6");
$service->execute();
$res_serv = $array = $service->fetchAll(PDO::FETCH_OBJ);
?>
<?php
$data = $pdo->prepare("SELECT * FROM employees order by id desc LIMIT 3");
$data->execute();
$res_data = $array = $data->fetchAll(PDO::FETCH_OBJ);
?>
<?php
$comment = $pdo->prepare("SELECT c.id, c.text, c.image, p.id as prodId, p.title, p.price, u.login, u.login FROM comments c INNER JOIN products p ON c.ProductID = p.id INNER JOIN users u ON c.userID = u.id WHERE c.image is not null order by id desc LIMIT 6;");
$comment->execute();
$comments = $comment->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css " rel="stylesheet "
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ " crossorigin="anonymous ">
    <title>Document</title>
</head>

<body>
<?php
require "head-footer/header.php";
?>
</div>
<div id="main" class="banner ">
    <h2 style="color: white">Интернет магазин</h2>
    <h1 style="color: white">Покупайте вещи не выходя из дома
        <p style="margin-bottom: 2%; color: black;"></p>
</div>
<div class="new-arrivals">
    <h2>Новинки</h2>
    <div class="card-container">
        <?php foreach ($res_serv as $serv): ?>
            <div class="card">
                <a href="detail.php?id=<?php echo $serv->id; ?>" class="black-link">
                    <img style="height: 238px;" src="admin/realising/images/<?php echo $serv->image ?>" alt="<?php echo $serv->title ?>"
                         class="card-img">
                    <div class="card-info">
                        <h3 class="card-title">
                            <?php echo $serv->title ?>
                        </h3>
                        <h4 class="card-price">От
                            <?php echo $serv->price ?> tg
                        </h4>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="catalog.php" class="show-more">Показать больше</a>
</div>
<br>
<br>
<h2 style="text-align: center; color: black; font-weight: bold;">Наша команда</h2>
<p style="text-align: center; color: black; ">Наши сотрудники будут работать чтобы вы смогли сделать удачную сделку
</p>
<div class="container">
    <?php foreach ($res_data as $datas): ?>
        <div class="employee-card">
            <img style="width: 40%" src="admin/realising/images/<?php echo $datas->image ?>" alt="Employee Photo">
            <h3>Employee Name:
                <?php echo $datas->name ?>
            </h3>
            <p>Job Title
                <?php echo $datas->job_title ?>
            </p>
        </div>
    <?php endforeach; ?>
</div>
<h2 style="text-align: center;padding: 15px 0 0px;">Популярные отзывы наших клиентов</h2>
<div class="grid-container">
    <?php foreach ($comments as $com): ?>
        <div style=" background-color: white" class="grid-item">
            <a href="detail.php?id=<?php echo $com->prodId; ?>#<?php echo $com->id; ?>" class="black-link">
                <img style="width: 80%; height: 60%" src="admin/realising/images/<?php echo $com->image ?>"
                     alt="Employee Photo">
                <p>User:
                    <?php echo $com->login ?>
                </p>
                <p>Text:
                    <?php echo $com->text ?>
                </p>
            </a>
        </div>
    <?php endforeach; ?>

</div>


<section class="forms">
    <div class="forms__content">
        <div class="forms__content-wrapper">
            <p class="forms__content-title">
                Подпишитесь на нашу рассылку
            </p>
            <p class="forms__content-description">
                Полезные статьи, акции, новости - получите все это сейчас!
            </p>
        </div>
        <form action="" class="form">
            <input type="text" placeholder="Ваш e-mail" class="form__input">
            <input type="submit" class="form__btn" value="Подписаться">
        </form>
        <p class="forms__content-text">
            Мы не шлем спам, и передаем никому ваши данные.
        </p>
    </div>
</section>
<div>

</div>
<?php require "head-footer/footer.php" ?>
</body>

</html>

<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 10px;
        background-color: white;
    }

    .grid-item {
        background-color: white;
        padding: 20px;
        font-size: 20px;
        text-align: center;
    }

    .grid-item img {
        height: auto;
        width: 80%;
        border-radius: 10%;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
    }

    .container {
        max-width: 1200px;
        margin: auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        grid-gap: 20px;
    }

    .employee-card {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .employee-card img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .employee-card h3 {
        margin: 0;
        font-size: 20px;
        color: #333;
    }

    .employee-card p {
        margin: 5px 0;
        color: #666;
    }
</style>