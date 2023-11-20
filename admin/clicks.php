
<?php
$user = "root";
$password = "";
$host = "localhost";
$db = "tourism";
$dbn = "mysql:host=".$host.';dbname='.$db.';charset=utf8';
$pdo = new PDO($dbn, $user, $password);
$pdo->exec("USE $db");

$service = $pdo->prepare("SELECT * FROM clicks order by id desc");
$service->execute();
$res_serv = $service->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Requests</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<?php require "../NavBar/header_admin.php" ?>
<body>

<?php foreach($res_serv as $serv):?>
    <div class="request">
        <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $serv->name?></h5>
                    <br>
                    <h3 class="card-text">От <?php echo $serv->number?></h3>
                </div>
        </div>
    </div>
<?php endforeach; ?>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: cyan;
    }
    .requests {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .request {
        margin-bottom: 20px;
        padding: 10px;
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
