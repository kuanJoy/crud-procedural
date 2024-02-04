<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["btn_edit_post"])) {
        var_dump($_POST['postEdit']);
        $desc = $_POST["post"]["desc"];
        $status = $_POST["post"]["status"];

        if (empty($desc)) {
            $errors_desc_edit = "Введите описание";
        } elseif ((!preg_match('/^.{3,4096}$/u', $desc))) {
            $errors_desc_edit = "Разрешается длина от 3 до 4096 символов.";
        } else {
            $desc = trim($desc);
        }

        if (empty($errors)) {
            $update_post = "UPDATE `posts` SET `description`= ?, `status` = ? WHERE `id_post` = {$_GET['edit_post']}";

            $params = ['si', $desc, $status];

            $result = executeQuery($connection, $update_post, $params);
            if ($result) {
                header("Location: profile.php");
                exit();
            } else {
                echo "<p class='alert'>Ошибка при редактировании</p>" . mysqli_error($connection);
            }
        }
    }
}
