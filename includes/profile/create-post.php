<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submitPost"])) {
        $post_desc = $_POST["post"]["description"];
        $id_user = $_SESSION["id_user"];

        if (empty($post_desc)) {
            $error_desc = "Описание не может быть пустым";
        } elseif ((!preg_match('/^.{3,4096}$/u', $post_desc))) {
            $error_desc = "Разрешается длина от 3 до 4096 символов.";
        } else {
            $post_desc = trim($post_desc);
        }

        if (empty($error_desc)) {
            $insert_post = "INSERT INTO `posts` (`id_post`, `description`, `id_user`, `status`) VALUES (NULL, ?, ?, 1)";
            $params = ['si', $post_desc, intval($id_user)];

            $query_insert_post = executeQuery($connection, $insert_post, $params);
            if ($query_insert_post) {
                $_POST['added'] = "Успешно добавлено";
                header("Location: profile.php");
                exit();
            } else {
                echo "<p class='alert'>Ошибка при добавлении публикации</p>" . mysqli_error($connection);
            }
        }
    }
}
