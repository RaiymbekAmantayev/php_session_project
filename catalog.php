<?php
$records_per_page = 9;

global $pdo;
require_once "./db/connect.php";

$count_query = $pdo->query("SELECT COUNT(*) AS count FROM products");
$count_result = $count_query->fetch(PDO::FETCH_ASSOC);
$total_records = $count_result['count'];


$total_pages = ceil($total_records / $records_per_page);

$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($current_page - 1) * $records_per_page;

$service = $pdo->prepare("SELECT * FROM products LIMIT :offset, :records_per_page");
$service->bindParam(':offset', $offset, PDO::PARAM_INT);
$service->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$service->execute();
$res_serv = $service->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Каталог</title>
</head>
<body>
<?php
require "head-footer/header.php";
?>
<div style="background-color: white">
    <h2 style="text-align: center; margin-top: 0%;">Каталог товаров</h2>
    <div style="margin: 2% 10% 2% 10%" class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach($res_serv as $serv):?>
            <div class="col">
                <div class="card h-100">
                    <a href="detail.php?id=<?php echo $serv->id; ?>">
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
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if($i === $current_page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php require "head-footer/footer.php" ?>
</div>

</body>
</html>


<style>

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-top: 50px;
        color: #333; /* Цвет текста */
    }

    /* Стили для карточек товаров */
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .card-img-top {
        height: 200px; /* Высота изображения */
        object-fit: cover;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .card-body {
        padding: 1.25rem;
    }

    .card-text {
        font-size: 1.5rem;
        color: #007bff;
    }


</style>