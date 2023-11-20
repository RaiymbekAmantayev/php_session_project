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
<h2 style="text-align: center; padding-top:180px">Sign Up</h2>
<form action="auth/Sign_Up.php" method="post" style="text-align: center; padding-top:70px">
    <div class="form-group">
        <input type="text" placeholder="enter ur name" name='name' required/>
    </div>
    <div class="form-group">
        <input type="text" placeholder="enter ur login" name='login' required/>
    </div>
    <div class="form-group">
        <input type="text" placeholder="enter ur password" name='password' required/>
    </div>
    <div class="form-group">
    <input type="password" name="confirm_password" placeholder="enter password again" required/>
    </div>
    <button type="submit" class="btn btn-primary">Sign Up</button>
</form>
</body>