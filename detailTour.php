<?php
global $pdo;
require_once "./functions/connect.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $service = $pdo->prepare("SELECT * FROM tour WHERE id = :id");
    $service->bindParam(':id', $id);
    $service->execute();
    $res_serv = $service->fetch(PDO::FETCH_OBJ);
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
require "NavBar/header.php";
?>
<div style="background-color: antiquewhite; text-align: center">
    <?php if(isset($res_serv)): ?>
        <h2 style="text-align: center; margin-top: 0%;"><?php echo $res_serv->title; ?></h2>
        <img src="admin/realising/images/<?php echo $res_serv->image; ?>" alt="...">
        <p>Цена: <?php echo $res_serv->price; ?></p>
        <p>Начало тура: <?php echo $res_serv->datastart; ?></p>
        <p>Конец тура: <?php echo $res_serv->dataend; ?></p>
    <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] === "admin") {
        ?>
    <a href="admin/updateTour.php?id=<?php echo $res_serv->id; ?>" class="black-link">
        <button class="btn btn-primary ">edit</button>
    </a>
    <form style="text-align: center;" action="admin/realising/delete.php" method="post">
        <input type="hidden" name="id_to_delete" value="<?php echo $res_serv->id; ?>">
        <button type="submit" name="delete" class="btn btn-primary ">delete</button>
    </form>

    <?php
        }
    ?>
    <?php else: ?>
        <p>Страна не найдена</p>
    <?php endif; ?>

</div>
<?php require "NavBar/footer.php"?>
</body>
</html>
