<?php

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "quotebook");


$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_error()) {
    printf("Подключение провалено: " . mysqli_connect_error());
    exit();
}

function executeQuery($connection, $sql, $params = null)
{
    $stmt = mysqli_prepare($connection, $sql);

    if ($params) {
        mysqli_stmt_bind_param($stmt, ...$params);
    }

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

session_start();
