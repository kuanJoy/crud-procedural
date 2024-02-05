<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["send"])) {
        $group_name = $_POST["group"]["name"];
        $group_fullname = $_POST["group"]["fullname"];
        $year_graduate = $_POST["group"]["year"];

        if (empty($group_name)) {
            $errors["name"] = "Введите группу";
        } elseif ((!preg_match('/^[\p{L}0-9 -]{3,40}$/u', $group_name))) {
            $errors["name"] = "Некорректное название группы. Длина от 3 до 40 символов";
        } else {
            $group_name = trim($group_name);
        }

        if (empty($group_fullname)) {
            $errors["fullname"] = "Введите название";
        } elseif ((!preg_match('/^[\p{L}0-9 -]{3,40}$/u', $group_fullname))) {
            $errors["fullname"] = "Некорректное название группы. Длина от 3 до 40 символов";
        } else {
            $group_fullname = trim($group_fullname);
        }

        if (empty($year_graduate)) {
            $errors["year"] = "Введите год";
        } elseif ($year_graduate <= 2001) {
            $errors["year"] = "Год должен быть не меньше 2001";
        } elseif ($year_graduate > 2025) {
            $errors["year"] = "Год должен быть не больше 2024";
        } else {
            $year_graduate = intval($year_graduate);
        }


        if (empty($errors)) {
            $insert_group = "INSERT INTO `groups` (`id_group`, `group_name`, `group_fullname`, `year_graduate`) VALUES (NULL, '$group_name', '$group_fullname', '$year_graduate')";
            $query_insert_group = mysqli_query($connection, $insert_group);

            if ($query_insert_group) {
                $_POST['added'] = "Успешно добавлено";
                header("Location: create.php?act=group");
                exit();
            } else {
                echo "<p class='alert'>Ошибка при добавлении</p>" . mysqli_error($connection);
            }
        }
    }
}
?>
<form class="create" action="" method="post">
    <div class="create_row">
        <label class="row_label " for="">Группа:</label>
        <input class="row_input" type="text" name="group[name]" placeholder="СИТ-1">
    </div>
    <div class="create_row">
        <label class="row_label " for="">Название:</label>
        <input class="row_input" type="text" name="group[fullname]" placeholder="Специалист интернет технологий">
    </div>
    <div class="create_row">

        <label class="row_label" for="">Год выпуска:</label>
        <input class="row_input" type="number" name="group[year]" placeholder="2024">
    </div>
    <?php
    show_errors();
    ?>
    <button class="my-btn" name="send" type="submit">Опубликовать</button>
</form>