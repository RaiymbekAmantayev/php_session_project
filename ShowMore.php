<?php
global $pdo;
require_once "./functions/connect.php";

$service = $pdo->prepare("SELECT * FROM tour");
$service->execute();
$res_serv = $service->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Популярные страны</title>
</head>
<body>
<?php
require "NavBar/header.php";
?>
<div style="background-color: antiquewhite">
    <h2 style="text-align: center; margin-top: 0%;">Популярные страны</h2>
    <div style="margin: 2% 10% 2% 10%" class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach($res_serv as $serv):?>
            <div class="col">
                <div class="card h-100">
                    <a href="detailTour.php?id=<?php echo $serv->id; ?>">
                        <img src="admin/realising/images/<?php echo $serv->image?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $serv->title?></h5>
                            <br>
                            <h3 class="card-text">От <?php echo $serv->price?></h3>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php require "NavBar/footer.php"?>
</div>

</body>
</html>
