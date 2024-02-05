<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["send"])) {
        $user_name = $_POST["users"]["name"];
        $user_surname = $_POST["users"]["surname"];
        $user_email = $_POST["users"]["email"];
        $id_group = $_POST["users"]["id_group"];
        $password = trim($_POST["users"]["pass"]);
        $repassword = trim($_POST["users"]["repass"]);
        $id_role = $_POST['users']['role'];

        if (empty($user_name)) {
            $errors["name"] = "Введите имя";
        } elseif ((!preg_match('/^[\p{L} -]{3,40}$/u', $user_name))) {
            $errors["name"] = "Цифры в имени недопустимы. Длина от 3 до 40 символов";
        } else {
            $user_name = trim($user_name);
        }

        if (empty($user_surname)) {
            $errors["surname"] = "Введите название";
        } elseif ((!preg_match('/^[\p{L} -]{3,40}$/u', $user_surname))) {
            $errors["surname"] = "Цифры в фамилии недопустимы. Длина от 3 до 40 символов";
        } else {
            $user_surname = trim($user_surname);
        }

        $errors = validate_email($errors, $user_email);

        $errors = validate_pass($errors, $password);

        if (empty($id_role)) {
            $errors['role'] = 'Выберите роль';
        } else {
            $id_role = trim($id_role);
        }

        if ($password == $repassword) {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            if ($_FILES['photo']['error'] === 4) {
                $img_upload_path = "./assets/images/upload/default_ava.jpg";
            } elseif (isset($_FILES['photo']['name'])) {
                $img_name = $_FILES['photo']['name'];
                $tmp_name = $_FILES['photo']['tmp_name'];

                if ($_FILES['photo']['error'] === 0) {

                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_to_lc = strtolower($img_ex);
                    $allowed_ex = ['jpg', 'jpeg', 'png'];

                    if (in_array($img_ex_to_lc, $allowed_ex)) {
                        $new_img_name = uniqid($user_email, true) . "." . "$img_ex_to_lc";
                        $img_upload_path = './assets/images/upload/' . $new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
                    } else {
                        $errors['photo_ex'] = "Поддерживаются только jpg, jpeg и png";
                    }
                } else {
                    $errors['photo_size'] = 'Неправильное имя фотографии или размер превышает 1 мегабайт';
                }
            }

            if (empty($errors)) {
                $insert_user = "INSERT INTO `users` (`id_user`, `name`, `surname`,`email`,`password`,`photo`,`id_group`, `id_role`) VALUES (NULL, ?, ?, ?, ?, ?, ?, 3)";
                $params = ["sssssi", $user_name, $user_surname, $user_email, $hash_password, $img_upload_path, intval($id_group)];
                $result_insert_user = executeQuery($connection, $insert_user, $params);
                if ($result_insert_user) {
                    $_SESSION['added'] = "Аккаунт успешно создан";
                    header("Location: ./login.php");
                    exit();
                } else {
                    echo "<p class='alert'>Ошибка при добавлении</p>" . mysqli_error($connection);
                }
            }
        } else {
            $errors["pass_not_match"] = "Пароли не совпадают";
        }
    }
}
?>
<div class="register">
    <h3 class="register__title">Регистрация</h3>
    <form class="create" action="" method="post" enctype="multipart/form-data">
        <?php
        if (isset($_POST['added'])) {
            echo $_POST['added'];
        }

        $sql_years = "SELECT DISTINCT `year_graduate` FROM `groups` WHERE `id_group` > 1 ORDER BY `year_graduate` DESC";
        $result_sql_years = mysqli_query($connection, $sql_years);

        ?>
        <div class="create_row">
            <div class="row_label ">Выберите год выпуска:</div>
            <div class="row_list" name="users[group]" id="">
                <?php if (mysqli_num_rows($result_sql_years)) {
                    while ($row = mysqli_fetch_assoc($result_sql_years)) { ?>
                        <a href="?act=user&year=<?= $row["year_graduate"] ?>"><?= $row["year_graduate"] ?> </a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php if (isset($_GET['year'])) { ?>
            <div class="create_row">
                <div class="row_label">Выберите группу: </div>
                <select name="users[id_group]">
                    <?php $year = $_GET['year'];
                    $selected_year = "SELECT * FROM `groups` WHERE year_graduate = '$year'";
                    $result_selected_year_groups = mysqli_query($connection, $selected_year);
                    if (mysqli_num_rows($result_selected_year_groups)) {
                        while ($row_two = mysqli_fetch_assoc($result_selected_year_groups)) { ?>
                            <option value="<?= $row_two['id_group']; ?>"><?= $row_two['group_name'] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div class="photo-inputs">
                <div class="form_photo">
                    <svg class="camera" height="23" width="23" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z" />
                    </svg>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                    <input type="file" name="photo">
                    <div class="photo__default">
                        <span>Выбрать стандартную</span><input type="checkbox" name="users[photo]">
                    </div>
                </div>
                <div class="form_rows">
                    <div class="create_row">
                        <label class="mw-5" for="">Имя:</label>
                        <input class="row_input" type="text" name="users[name]">
                    </div>
                    <div class="create_row">
                        <label class="mw-5" for="">Фамилия:</label>
                        <input class="row_input" type="text" name="users[surname]">
                    </div>
                    <div class="create_row">
                        <label class="mw-5" for="">Почта:</label>
                        <input class="row_input" type="email" name="users[email]">
                    </div>
                    <div class="create_row">
                        <label class="mw-5" for="">Пароль:</label>
                        <input class="row_input" type="password" name="users[pass]">
                    </div>
                    <div class="create_row">
                        <label class="mw-5" for="">Повторите пароль:</label>
                        <input class="row_input" type="password" name="users[repass]">
                    </div>
                    <input class="row_input" type="hidden" name="users[role]" value="3">
                </div>
            </div>
            <?php
            show_errors();
            ?>
            <button class="my-btn" name="send" type="submit">Создать аккаунт</button>
        <?php } ?>
        <a class="login-exist" href="/login.php">Войти в существующий</a>
    </form>
</div>