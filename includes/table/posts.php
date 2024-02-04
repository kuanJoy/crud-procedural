<?php
// =================== СКРИПТ УДАЛЕНИЕ ЧЕКБОКСЫ ===================
if (isset($_POST['delete_all'])) {
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
    for ($i = 0; $i < count($_POST['checkbox']); $i++) {
        $id_post = intval($_POST['checkbox'][$i]);
        $query_delete = "DELETE FROM `posts` WHERE `id_post` = $id_post;";
        mysqli_query($connection, $query_delete);
    }
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");
    header("Location: table.php?table=posts");
    exit();
}
?>

<?php
// =================== СКРИПТ УДАЛЕНИЕ ПОСТА ===================
if (isset($_GET['delete'])) {
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
    $one_post = $_GET['delete'];
    mysqli_query($connection, "DELETE FROM posts WHERE id_post = $one_post");
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");
    header("Location: table.php?table=posts");
    exit();
}
?>

<?php
// =================== СКРИПТ РЕДАКТИРОВАНИЕ ПОСТА ===================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["make_edit"])) {
        $desc = $_POST["post"]["desc"];
        $status = $_POST["post"]["status"];

        if (empty($desc)) {
            $errors["desc"] = "Введите описание";
        } elseif ((!preg_match('/^.{3,4096}$/u', $desc))) {
            $errors["desc"] = "Разрешается длина от 3 до 4096 символов.";
        } else {
            $desc = trim($desc);
        }

        if (empty($errors)) {
            $update_post = "UPDATE `posts` SET `description`= ?, `status` = ? WHERE `id_post` = {$_GET['edit']}";

            $params = ['si', $desc, $status];

            $result = executeQuery($connection, $update_post, $params);
            if ($result) {
                header("Location: table.php?table=posts");
                exit();
            } else {
                echo "<p class='alert'>Ошибка при редактировании</p>" . mysqli_error($connection);
            }
        }
    }
}
show_errors(); ?>

<div class="table-content">
    <form action="" method="post">
        <table class="table">
            <thead class="table_block">
                <tr class="table_row">
                    <th class="table_cell w-1"></th>
                    <th class="table_cell id">ID</th>
                    <th class="table_cell post-desc">Описание</th>
                    <th class="table_cell created-at">Дата</th>
                    <th class="table_cell author">Автор</th>
                    <th class="table_cell author">Статус</th>
                    <th class="table_cell btns-cell">Действия</th>
                </tr>
            </thead>
            <tbody class="table_block">
                <?php
                $select_posts = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.name, users.surname
            FROM posts JOIN users ON posts.id_user = users.id_user;";
                if ($result_select_posts = mysqli_query($connection, $select_posts)) {
                    $items_per_page = 10;
                    $num_rows = mysqli_num_rows($result_select_posts);
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
                    $limit = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.name, users.surname
            FROM posts JOIN users ON posts.id_user = users.id_user LIMIT $items_per_page OFFSET $start";
                    $result_limit = mysqli_query($connection, $limit);
                    while ($row = mysqli_fetch_assoc($result_limit)) {
                ?>
                        <tr class="table_row">
                            <td class="table_cell">
                                <input type="checkbox" name="checkbox[]" value="<?= $row['id_post'] ?>">
                            </td>
                            <td class="table_cell id"><?= $row['id_post'] ?></td>
                            <td class="table_cell"><?= $row['description'] ?></td>
                            <td class="table_cell"><?php echo substr($row['posts_time'], 0, 8); ?></td>
                            <td class="table_cell"><?php echo $row['name'] . " "  . $row['surname'] ?></td>
                            <td class="table_cell"><?= $row['status'] ?></td>
                            <td class="table_cell">
                                <!-- =============== SVG РЕДАКТИРОВАНИЕ =============== -->
                                <a href="table.php?table=posts&edit=<?= $row['id_post'] ?>" class="table_btn">
                                    <svg class="icon pd-left-3 ">
                                        <use href="./assets/images/svg/sprites.svg#edit" />
                                    </svg>
                                </a>
                                <!-- =============== SVG УДАЛЕНИЕ =============== -->
                                <a href="table.php?table=posts&delete=<?= $row['id_post'] ?>" name="delete" class="table_btn" onclick="return showConfirmation()">
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
                        pagination($result_limit, $total_pages, "/table.php?table=posts&page");
                        ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    </form>
</div>