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
<?php
require "NavBar/header.php";
?>
<h2 style="text-align: center; padding-top:180px">Change Password</h2>
<form action="auth/changePass.php" method="post" style="text-align: center; padding-top:70px">
    <div class="form-group">
        <input type="text" placeholder="enter old Password" name="old"/>
    </div>
    <div class="form-group">
        <input type="password" placeholder="enter new Password" name="new"/> <!-- Поле для ввода пароля -->
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>