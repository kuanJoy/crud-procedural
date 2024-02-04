<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["send"])) {
        $post_desc = $_POST["post"]["description"];
        $id_user = $_POST["post"]["id_user"];

        if (empty($post_desc)) {
            $errors["desc"] = "Описание не может быть пустым";
        } elseif ((!preg_match('/^.{3,4096}$/u', $post_desc))) {
            $errors["desc"] = "Разрешается длина от 3 до 4096 символов.";
        } else {
            $post_desc = trim($post_desc);
        }

        if (empty($errors)) {
            $insert_post = "INSERT INTO `posts` (`id_post`, `description`, `id_user`, `status`) VALUES (NULL, ?, ?, 1)";
            $params = ['si', $post_desc, $id_user];

            $query_insert_post = executeQuery($connection, $insert_post, $params);

            if ($query_insert_post) {
                $_POST['added'] = "Успешно добавлено";
                header("Location: create.php?act=post");
                exit();
            } else {
                echo "<p class='alert'>Ошибка при добавлении публикации</p>" . mysqli_error($connection);
            }
        }
    }
}
?>

<form class="create" action="" method="post">
    <?php
    $sql_years = "SELECT DISTINCT `year_graduate` FROM `groups` WHERE `id_group` > 1";
    $result_sql_years = mysqli_query($connection, $sql_years);
    ?>
    <div class="create_row">
        <label class="row_label ">Выберите год выпуска:</label>
        <div class="row_list" name="users[group]" id="">
            <?php if (mysqli_num_rows($result_sql_years)) {
                while ($row = mysqli_fetch_assoc($result_sql_years)) {
                    $year_grad = $row["year_graduate"] ?>
                    <a href="?act=post&year=<?= $year_grad ?>"><?= $year_grad ?> </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php if (isset($_GET['year'])) { ?>
        <div class="create_row">
            <label class="row_label ">Выберите группу: </label>
            <div class="row_list">
                <?php $year = $_GET['year'];
                $selected_year = "SELECT * FROM `groups` WHERE year_graduate = '$year'";
                $result_selected_year_groups = mysqli_query($connection, $selected_year);
                if (mysqli_num_rows($result_selected_year_groups)) {
                    while ($row_two = mysqli_fetch_assoc($result_selected_year_groups)) { ?>
                        <a href="?act=post&year=<?= $year ?>&id_group=<?php $id_group = $row_two['id_group']; // нужно сохранить в новую переменную, чтобы использовать его значение в hidden inpute
                                                                        echo $id_group ?>" value="<?= $id_group ?>"><?= $row_two['group_name'] ?> </a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?php
    if (isset($_GET['id_group'])) {
        $selected_group = $_GET['id_group'];
        $selected_users = "SELECT * FROM `users` WHERE id_group = '$selected_group'";
        $result_selected_users_by_group = mysqli_query($connection, $selected_users);

        if (mysqli_num_rows($result_selected_users_by_group)) { ?>
            <div class="create_row">
                <label class="row_label" for="">Выберите студента:</label>
                <select class="row_input w-65" name="post[id_user]">
                    <?php while ($row_three = mysqli_fetch_assoc($result_selected_users_by_group)) { ?>
                        <option value="<?php $id_user =  $row_three['id_user'];
                                        echo $id_user ?>">
                            <?php echo $row_three['name'] . ' ' . $row_three['surname'];  ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="create_quote-btns">
                <textarea class="create_post" name="post[description]"></textarea>
                <div class="create_btns">
                    <button class="my-btn" name="send" type="submit">Опубликовать</button>
                </div>
            </div>
        <?php } else {
            echo "<span class='alert'>В группе отсутствуют студенты</span>";
        } ?>
    <?php }
    show_errors();
    ?>
</form>