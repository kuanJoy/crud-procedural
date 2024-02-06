<?php
// =================== СКРИПТ УДАЛЕНИЯ ЧЕКБОКСЫ ===================
if (isset($_POST['delete_all'])) {
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
    for ($i = 0; $i < count($_POST['checkbox']); $i++) {
        $id_user = intval($_POST['checkbox'][$i]);

        $get_photo_to_del = "SELECT users.photo FROM users WHERE `id_user` = $id_user";
        $result_get_photo_to_del = mysqli_query($connection, $get_photo_to_del);
        $row_pic = mysqli_fetch_assoc($result_get_photo_to_del);
        $picture_path = $row_pic['photo'];
        if ($picture_path !== "./assets/images/upload/default_ava.jpg") {
            unlink($picture_path);
        }

        $query_update = "UPDATE `posts` SET `id_user` = 1 WHERE `id_user` = $id_user";
        mysqli_query($connection, $query_update);
        $query_delete = "DELETE FROM `users` WHERE `id_user` = $id_user;";

        mysqli_query($connection, $query_delete);
    }
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");
    header("Location: table.php?table=users");
    exit();
}
?>


<?php
// =================== СКРИПТ УДАЛЕНИЕ ПОЛЬЗОВАТЕЛЯ ===================
if (isset($_GET['delete'])) {
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
    $one_post = $_GET['delete'];

    $get_photo_to_del = "SELECT users.photo FROM users WHERE `id_user` = {$_GET['delete']}";
    $result_get_photo_to_del = mysqli_query($connection, $get_photo_to_del);
    $row_pic = mysqli_fetch_assoc($result_get_photo_to_del);
    $picture_path = $row_pic['photo'];
    if ($picture_path !== "./assets/images/upload/default_ava.jpg") {
        unlink($picture_path);
    }

    $query_update = "UPDATE `posts` SET `id_post` = 1 WHERE `id_post` = $one_post";
    mysqli_query($connection, $query_update);
    mysqli_query($connection, "DELETE FROM users WHERE id_user = $one_post");
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");
    header("Location: table.php?table=users");
    exit();
}
?>

<?php
// =================== СКРИПТ РЕДАКТИРОВАНИЕ ПОЛЬЗОВАТЕЛЯ ===================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["make_edit"])) {
        $name = $_POST["user"]["name"];
        $surname = $_POST["user"]["surname"];
        $email = $_POST["user"]["email"];
        $id_role = $_POST['user']['role'];
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
            $errors["surname"] = "Некорректная фамилия. Цифры недопустимы. Длина от 3 до 40 символов.";
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

        if (empty($errors)) {
            // вырубаем ибо не можем обновить UNIQUE email
            mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
            $update_user = "UPDATE `users` SET `name`= ?, `surname` = ?, `email`= ?, `photo` = ?, `id_group` = ?, `id_role` = ?  WHERE `id_user` = {$_GET['edit']} ";
            mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");

            $params = ['ssssii', $name, $surname, $email, $img_upload_path, $id_group, $id_role];

            $result = executeQuery($connection, $update_user, $params);
            if ($result) {
                header("Location: table.php?table=users");
                exit();
            } else {
                echo "<p class='alert'>Ошибка при добавлении</p>" . mysqli_error($connection);
            }
        }
    }
}
show_errors();
?>

<div class="table-content">
    <form action="" method="post">
        <table class="table">
            <thead class="table_block">
                <tr class="table_row">
                    <th class="table_cell w-1"></th>
                    <th class="table_cell id"><a class="line" href="/table.php?table=users&sort=id_user">ID</a></th>
                    <th class="table_cell name">Имя</th>
                    <th class="table_cell surname">Фамилия</th>
                    <th class="table_cell email">Почта</th>
                    <th class="table_cell group"><a class="line" href="/table.php?table=users&sort=group">Группа</a></th>
                    <th class="table_cell group">Роль</th>
                    <th class="table_cell btns-cell">Действия</th>
                </tr>
            </thead>
            <tbody class="table_block">
                <?php
                // ========================= СОРТИРОВКА СТУДЕНТОВ ПО АЛФАВИТУ И ПО АЙДИ =======================
                if (isset($_GET['sort']) && $_GET['sort'] == 'group') {
                    $select_users = "SELECT users.id_user, users.name, users.surname, users.email, users.photo, groups.group_name, roles.id_role, roles.role_name
                FROM users 
                JOIN groups ON users.id_group = groups.id_group 
                JOIN roles ON users.id_role = roles.id_role 
                WHERE users.id_user > 2 
                ORDER BY groups.group_name ASC";
                } else {
                    $select_users = "SELECT users.id_user, users.name, users.surname, users.email, users.photo, groups.group_name, roles.id_role, roles.role_name
                FROM users JOIN groups ON users.id_group = groups.id_group JOIN roles ON users.id_role = roles.id_role WHERE users.id_user > 2";
                }

                if ($result_select_users = mysqli_query($connection, $select_users)) {
                    $items_per_page = 10;
                    $num_rows = mysqli_num_rows($result_select_users);
                    $total_pages = ceil($num_rows / $items_per_page);

                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        if ($page > $total_pages) {
                            $page = 1;
                        }
                    } else {
                        $page = 1;
                    }

                    $start = ($page - 1) * $items_per_page;

                    if (isset($_GET['sort']) && $_GET['sort'] == 'group') {
                        $limit = $select_users . " LIMIT $items_per_page OFFSET $start";
                    } else {
                        $limit = $select_users . " LIMIT $items_per_page OFFSET $start";
                    }

                    $result_limit = mysqli_query($connection, $limit);
                    while ($row = mysqli_fetch_assoc($result_limit)) { ?>
                        <tr class="table_row">
                            <td class="table_cell">
                                <input type="checkbox" name="checkbox[]" value="<?= $row['id_user'] ?>">
                            </td>
                            <td class="table_cell id"><?= $row['id_user'] ?></td>
                            <td class="table_cell"><?= $row['name'] ?></td>
                            <td class="table_cell"><?= $row['surname'] ?></td>
                            <td class="table_cell"><?= $row['email'] ?></td>
                            <td class="table_cell"><?= $row['group_name'] ?></td>
                            <td class="table_cell"><?= $row['role_name'] ?></td>
                            <td class="table_cell">
                                <!-- =============== SVG РЕДАКТИРОВАНИЕ =============== -->
                                <a href="?table=users&edit=<?= $row['id_user'] ?>" name="edit" class=" table_btn">
                                    <svg class="icon pd-left-3 ">
                                        <use href="./assets/images/svg/sprites.svg#edit" />
                                    </svg>
                                </a>
                                <!-- =============== SVG УДАЛЕНИЕ =============== -->
                                <a href="?table=users&delete=<?= $row['id_user'] ?>" name="delete" class="table_btn" onclick=" return showConfirmation();">
                                    <svg class=" icon pd-left-3 ">
                                        <use href=" ./assets/images/svg/sprites.svg#delete" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
            <tfoot class="tfoot">
                <tr class="table_row">
                    <th class="table_cell">
                        <button type="submit" name="delete_all" onclick="return showConfirmation();">
                            <svg class="icon pd-left-3 ">
                                <use href="./assets/images/svg/sprites.svg#delete" />
                            </svg>
                        </button>
                    </th>
                    <th class="pagination">
                        <?php
                        pagination($num_rows, $total_pages, "/table.php?table=users&page");
                        ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    </form>
</div>