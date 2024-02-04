<?php
include "./layout/header.php";
include "./layout/nav-sidebar.php";
// Навигация для создания - Публикации / Пользователя / Группы

if (isset($_SESSION['id_role'])) {
    if ($_SESSION['id_role'] == 1 || $_SESSION['id_role'] == 2) { ?>
        <div class="main_content">
            <div class="btns-nav">
                <h3 class="main_title"><svg class="icon grey mh-19">
                        <use href="./assets/images/svg/sprites.svg#add" />
                    </svg>Добавить</h3>
                <a href="?act=post" class="my-btn">Цитату</a>
                <a href="?act=user" class="my-btn">Студента</a>
                <a href="?act=group" class="my-btn">Группу</a>
            </div>
    <?php
        if (isset($_GET["act"])) {
            switch ($_GET["act"]) {
                case "post":
                    include "./includes/create/post.php";
                    include "./includes/mini-table/posts.php";
                    break;
                case "user":
                    include "./includes/create/user.php";
                    include "./includes/mini-table/users.php";
                    break;
                case "group":
                    include "./includes/create/group.php";
                    include "./includes/mini-table/groups.php";
                    break;
                default:
                    break;
            }
        }
    }
} ?>
        </div>

        <?php
        include "./layout/footer.php";
        ?>