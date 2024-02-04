<?php

include "./layout/header.php";
include "./layout/nav-sidebar.php";

if (isset($_SESSION['id_role'])) {
    if ($_SESSION['id_role'] == 1 || $_SESSION['id_role'] == 2) { ?>
        <div class="main_content">
            <div class="btns-nav">
                <h3 class="main_title"><svg class="icon grey">
                        <use href="./assets/images/svg/sprites.svg#table" />
                    </svg> Таблица</h3>
                <a href="?table=posts" class="my-btn">Цитат</a>
                <a href="?table=users" class="my-btn">Студентов</a>
                <a href="?table=groups" class="my-btn">Групп</a>
            </div>
            <?php
            if (isset($_GET["table"])) {
                $button = $_GET["table"];

                switch ($button) {
                    case "posts":
                        include "./includes/table/posts.php";
                        break;
                    case "users":
                        include "./includes/table/users.php";
                        break;
                    case "groups":
                        include "./includes/table/groups.php";
                        break;
                    default:
                        break;
                }
            }
            ?>
        </div>
        <div class="right-sidebar">
    <?php
        if (isset($_GET['show_users'])) {
            include "./includes/table/show_users.php";
        }
        if (isset($_GET["table"])) {
            $button = $_GET["table"];

            switch ($button) {
                case "posts":
                    include "./includes/edit-panel/edit-posts.php";
                    break;
                case "users":
                    include "./includes/edit-panel/edit-users.php";
                    break;
                case "groups":
                    include "./includes/edit-panel/edit-groups.php";
                    break;
                default:
                    break;
            }
        }
    }
} ?>
    <?php
    include "./layout/footer.php";
    ?>