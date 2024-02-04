<?php

include "./layout/header.php";
include "./layout/nav-sidebar.php";
if (isset($_SESSION['authorized'])) {
    header("Location: home.php");
} elseif (!isset($_SESSION['authorized'])) {
    header("Location: home.php");
}
include "./layout/footer.php";
