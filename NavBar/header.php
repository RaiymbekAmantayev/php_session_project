<div class="navigation">
    <div class="container">
        <div class="logo" style="font-weight: bold; font-size: larger; color: blue;">
            Tourism Project
        </div>

        <ul>
            <?php
            // Начинаем сессию
            session_start();

            // Проверка наличия активной сессии
            if (isset($_SESSION['login']) && !empty($_SESSION['login']) && $_SESSION['login'] != 'admin') {
                ?>
                <li>
                    <a href="/practice.php">Главная</a>
                </li>
                <li>
                    <a href="/practice.php#Form">Оставить заявку</a>
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
                    <a href="/admin/addTour.php">Добавить</a>
                </li>
                <li>
                    <a href="/admin/clicks.php">Заявки</a>
                </li>
                <li>
                    <a href="/practice.php">Отклики</a>
                </li>
                <li>
                    <a href="/practice.php">Архивы</a>
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