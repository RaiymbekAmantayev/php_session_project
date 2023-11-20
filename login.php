<!DOCTYPE html>
<html>
<head>
    <title>Тестовый сайт</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require "NavBar/header.php"?>
<h2 style="text-align: center; padding-top:180px">Sign In </h2>
<form action="auth/login.php" method="post" style="text-align: center; padding-top:70px">
    <div class="form-group">
        <input type="text" placeholder="enter login" name="login"/>
    </div>
    <div class="form-group">
        <input type="password" placeholder="enter password" name="password"/> <!-- Поле для ввода пароля -->
    </div>
    <button type="submit" class="btn btn-primary">Sign In</button>
</form>
<?php require "NavBar/footer.php"?>
</body>