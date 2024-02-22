<div class="navigation">
    <div class="container">
        <div class="logo" style="font-weight: bold; font-size: larger; color: blue;">
            <a href="/index.php">SHOP</a>
        </div>

        <ul>
            <?php
            session_start();
            if (isset($_SESSION['login']) && !empty($_SESSION['login']) && $_SESSION['login'] != 'admin') {
                ?>
                <li>
                    <a href="/catalog.php">Каталог</a>
                </li>
                <li>
                    <a href="/my_orders.php">Мои заказы</a>
                </li>
                <li>
                    <a href="/fav_view.php">Избранные</a>
                </li>
                <li>
                    <a href="/ChangePass.php">Изменить пароль</a>
                </li>
                <li>
                    <a href="/logout.php">Выйти</a>
                </li>
                <?php
            } else if(isset($_SESSION['login']) && $_SESSION['login'] === 'admin') {
                ?>
                <li>
                    <a href="/admin/addProduct.php">Добавить</a>
                </li>
                <li>
                    <a href="/admin/orders_view.php">Заказы</a>
                </li>
                <li>
                    <a href="/admin/addEmployees.php">Сотрудники</a>
                </li>
                <li>
                    <a href="/ChangePass.php">Изменить пароль</a>
                </li>
                <li>
                    <a href="/logout.php">Выйти</a>
                </li>
                <?php
            }else{
            ?>
                <li>
                    <a href="/login.php">Войти</a>
                </li>
                <li>
                    <a href="/Sign_Up.php">Регистрация</a>
                </li>
            <?php
            }
            ?>


        </ul>
    </div>
</div>