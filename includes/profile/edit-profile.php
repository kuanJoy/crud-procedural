<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["btn_edit_profile"])) {
        $name = $_POST["user"]["name"];
        $surname = $_POST["user"]["surname"];
        $email = $_POST["user"]["email"];
        $new_photo = $_POST['user']['photo'];
        $old_photo = $_POST['user']['old_photo'];

        $group_name = $_POST['user']['group_name'];
        $year_graduate = $_POST['user']['year_graduate'];

        if (empty($group_name)) {
            $errors['null_group_name'] = "Введите название группы";
        }
        if (empty($year_graduate)) {
            $errors['null_year'] = "Введите год выпуска";
        }

        $select_id_by_group_name_and_year = "SELECT `id_group` FROM `groups` WHERE groups.group_name = '$group_name' AND groups.year_graduate = $year_graduate";
        if ($group_name !== "" && $year_graduate !== "") {
            if (($result_select_id = mysqli_query($connection, $select_id_by_group_name_and_year))) {
                $row_id = mysqli_fetch_array($result_select_id);
                $id_group = $row_id['id_group'];
                $id_group = intval($id_group);
            } else {
                $errors['year_and_group'] = 'Нет такой группы или года выпуска';
            }
        }

        if (empty($name)) {
            $errors["name"] = "Введите имя";
        } elseif ((!preg_match('/^[\p{L} -]{3,40}$/u', $name))) {
            $errors["name"] = "Некорректное имя. Цифры недопустимы. Длина от 3 до 40 символов.";
        } else {
            $name = trim($name);
        }

        if (empty($surname)) {
            $errors["surname"] = "Введите фамилию";
        } elseif ((!preg_match('/^[\p{L} -]{3,40}$/u', $surname))) {
            $errors["surname"] = "Некорректная фамилия. Длина от 3 до 40 символов.";
        } else {
            $surname = trim($surname);
        }

        if (empty($email)) {
            $errors['email'] = 'Введите почту';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некорректная почта';
        }

        if ($_FILES['photo']['error'] == 4 && $new_photo == $old_photo) {
            $img_upload_path = $old_photo;
        } elseif ($_FILES['photo']['error'] === 4 && $new_photo !== $old_photo) {
            unlink($old_photo);
            $img_upload_path = $new_photo;
        } elseif ($new_photo == "./assets/images/upload/default_ava.jpg" && $_FILES['photo']['error'] == 4) {
            $img_upload_path = $new_photo;
        }

        if (!empty($_FILES['photo']['name'])) {
            if ($_FILES['photo']['error'] === 0) {
                $img_name = $_FILES['photo']['name'];
                $tmp_name = $_FILES['photo']['tmp_name'];
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_to_lc = strtolower($img_ex);
                $allowed_ex = ['jpg', 'jpeg', 'png'];

                if (in_array($img_ex_to_lc, $allowed_ex)) {
                    $new_img_name = uniqid($email, true) . "." . "$img_ex_to_lc";
                    $img_upload_path = './assets/images/upload/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // Удаление старого файла только если он не равен default_ava.jpg и существует
                    if ($old_photo !== "./assets/images/upload/default_ava.jpg" && file_exists($old_photo)) {
                        unlink($old_photo);
                    }
                } else {
                    $errors['photo_ex'] = "Поддерживаются только jpg, jpeg и png";
                }
            } else {
                $errors['photo_size'] = 'некорректное название или размер превышает 1 мегабайт';
            }
        } else {
            $img_upload_path = $new_photo;
        }

        if (empty($errors) && isset($id_group)) {
            // вырубаем ибо не можем обновить UNIQUE email
            mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
            $update_user = "UPDATE `users` SET `name`= ?, `surname` = ?, `email`= ?, `photo` = ?, `id_group` = ? WHERE `email` = ?";

            mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");

            $params = ['ssssis', $name, $surname, $email, $img_upload_path, $id_group, $email];
            $result = executeQuery($connection, $update_user, $params);
            if ($result) {
                header("Location: profile.php");
                exit();
            } else {
                echo "<p class='alert'>Ошибка при добавлении</p>" . mysqli_error($connection);
            }
        }
    }
}
