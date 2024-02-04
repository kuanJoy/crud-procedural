<?php
if (isset($_GET['delete'])) {
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
    $one_post = $_GET['delete'];
    mysqli_query($connection, "DELETE FROM posts WHERE id_post = $one_post");
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");
    header("Location: profile.php");
    exit();
}
