<?php
$user = "root";
$password = "";
$host = "localhost";
$db = "tourism";
$dbn = "mysql:host=".$host.';dbname='.$db.';charset=utf8';
$pdo = new PDO($dbn, $user, $password);
$pdo->exec("USE $db");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $service = $pdo->prepare("SELECT * FROM tour WHERE id = :id");
    $service->bindParam(':id', $id);
    $service->execute();
    $res_serv = $service->fetch(PDO::FETCH_OBJ);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php require "../NavBar/header_admin.php"?>
    <h1>Editing tourism information</h1>
    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === "admin"): ?>
        <p style="text-align: center">Good day, <?php echo $_SESSION['login']; ?></p>
    <?php endif; ?>
    <a href="/practice.php" class="d-block text-center mb-4">Main Page</a>

    <form action="/admin/realising/update.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $res_serv->id; ?>">
            <input type="text" class="form-control" placeholder="Enter title" name="title" value="<?php echo $res_serv->title; ?>" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Price" name="price" value="<?php echo $res_serv->price; ?>" required>
        </div>
        <div class="form-group">
            <input type="file" class="form-control" name="image" id="image" accept="image/*" value="<?php echo $res_serv->image; ?>" required>
        </div>
        <div class="form-group">
            <input type="date" class="form-control" placeholder="Start date" name="datastart" value="<?php echo $res_serv->datastart; ?>" required>
        </div>
        <div class="form-group">
            <input type="date" class="form-control" placeholder="End date" name="dataend" value="<?php echo $res_serv->dataend; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Save</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<style>
    body {
        background-image: url('realising/images/id.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        align-items: center;
    }

    .container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 10px;
    }

    .form-control {
        border-radius: 5px;
    }

    h1 {
        text-align: center;
    }
</style>
