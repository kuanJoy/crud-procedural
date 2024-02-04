<?php
include "./layout/header.php";
include "./layout/nav-sidebar.php";
if (isset($_SESSION['authorized'])) {
    header("Location: home.php");
    exit();
}
include "./includes/register.php";
include "./layout/footer.php";
