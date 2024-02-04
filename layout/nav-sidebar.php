<header class="header">
    <div class="header_name-logo">
        <svg class="icon">
            <use href="./assets/images/svg/sprites.svg#logo" />
        </svg>
        <h3 class="header_name">Цитатник 98</h3>
    </div>
    <ul class="nav">
        <a href="./home.php" class="nav__link">
            <svg class="icon">
                <use href="./assets/images/svg/sprites.svg#home" />
            </svg>
            Главная
        </a>
        <!-- ЧЕК НА РОЛЬ АДМИН ПАНЕЛЕЙ -->
        <?php if (isset($_SESSION['id_role'])) {
            if ($_SESSION['id_role'] == 1 || $_SESSION['id_role'] == 2) { ?>
                <a href="./create.php?act=post" class="nav__link">
                    <svg class="icon">
                        <use href="./assets/images/svg/sprites.svg#add" />
                    </svg>
                    Добавить
                </a>
                <a href="./table.php?table=posts" class="nav__link">
                    <svg class="icon">
                        <use href="./assets/images/svg/sprites.svg#table" />
                    </svg>
                    Таблицы
                </a>
            <?php } ?>
        <?php } ?>
        <!-- ЧЕК СЕССИИ НА ВХОД -->
        <?php
        if (!isset($_SESSION['authorized'])) { ?>
            <a href="./login.php" class="nav__link">
                <svg class="icon">
                    <use href="./assets/images/svg/sprites.svg#add-user" />
                </svg>
                Войти
            </a>
        <?php } ?>

        <?php if (isset($_GET['logout'])) {
            session_destroy();
            header("Location: index.php");
        }
        ?>

        <!-- ЧЕК СЕССИИ НА ВЫХОД И ОТОБРАЖЕНИЕ ПРОФИЛЯ -->
        <?php if (isset($_SESSION['authorized'])) {
        ?>
            <a href="/profile.php" class="nav__link"><svg class="icon">
                    <use href="./assets/images/svg/sprites.svg#user" />
                </svg>
                Профиль
            </a>
            <a href="?logout" class="nav__link"><svg class="icon">
                    <use href="./assets/images/svg/sprites.svg#quit" />
                </svg>
                Выйти
            </a>
        <?php } ?>
    </ul>
</header>
<main class="main">