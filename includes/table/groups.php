<?php
// =================== СКРИПТ УДАЛЕНИЕ ЧЕКБОКСЫ ===================
if (isset($_POST['delete_all'])) {
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
    for ($i = 0; $i < count($_POST['checkbox']); $i++) {
        $id_group = intval($_POST['checkbox'][$i]);
        $query_update = "UPDATE `users` SET `id_group` = 0 WHERE `id_group` = $id_group";
        mysqli_query($connection, $query_update);
        $query_delete = "DELETE FROM `groups` WHERE `id_group` = $id_group;";
        mysqli_query($connection, $query_delete);
    }
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");
    header("Location: table.php?table=groups");
    exit();
}
?>


<?php
// =================== СКРИПТ УДАЛЕНИЕ ГРУППЫ ===================
if (isset($_GET['delete'])) {
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=0");
    $one_post = $_GET['delete'];
    $query_update = "UPDATE `users` SET `id_group` = 0 WHERE `id_group` = $one_post";
    mysqli_query($connection, $query_update);
    mysqli_query($connection, "DELETE FROM groups WHERE id_group = $one_post");
    mysqli_query($connection, "SET FOREIGN_KEY_CHECKS=1");
    header("Location: table.php?table=groups");
    exit();
} ?>

<?php
// ================== СКРИПТ CОЗДАНИЕ ГРУППЫ ==================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["make_edit"])) {
        $group_name = $_POST["group"]["name"];
        $group_fullname = $_POST["group"]["fullname"];
        $year_graduate = $_POST["group"]["year"];
        $id_group = $_POST['group']['id_group'];

        if (empty($group_name)) {
            $errors["name"] = "Введите группу";
        } elseif ((!preg_match('/^[\p{L}0-9 -]{3,40}$/u', $group_name))) {
            $errors["name"] = "Некорректное название группы. Длина от 3 до 40 символов.";
        } else {
            $group_name = trim($group_name);
        }

        if (empty($group_fullname)) {
            $errors["fullname"] = "Введите название";
        } elseif ((!preg_match('/^[\p{L}0-9 -]{3,40}$/u', $group_fullname))) {
            $errors["fullname"] = "Некорректное название группы. Длина от 3 до 40 символов.";
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
            $update_group = "UPDATE `groups` SET `group_name`= ?, `group_fullname` = ?, `year_graduate`= ? WHERE `id_group` = ?";

            $params = ['ssii', $group_name, $group_fullname, $year_graduate, $id_group];

            $result = executeQuery($connection, $update_group, $params);
            if ($result) {
                header("Location: table.php?table=groups");
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
                    <th class=" table_cell id">ID</th>
                    <th class="table_cell group">Группа</th>
                    <th class="table_cell">Название</th>
                    <th class="table_cell year-graduate">Год выпуска</th>
                    <th class="table_cell btns-cell">Действия</th>
                </tr>
            </thead>
            <tbody class="table_block">
                <?php
                $select_groups = "SELECT * FROM `groups` WHERE id_group > 1";
                if ($result_select_groups = mysqli_query($connection, $select_groups)) {
                    $items_per_page = 10;
                    $num_rows = mysqli_num_rows($result_select_groups);
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
                    $limit = "SELECT * FROM `groups` WHERE id_group > 1 LIMIT $items_per_page OFFSET $start";
                    $result_limit = mysqli_query($connection, $limit);
                    while ($row = mysqli_fetch_assoc($result_limit)) { ?>
                        <tr class="table_row">
                            <td class="table_cell">
                                <input type="checkbox" name="checkbox[]" value="<?= $row['id_group'] ?>">
                            </td>
                            <td class=" table_cell id"><?= $row['id_group'] ?></td>
                            <td class="table_cell"><a class="line" href="/table.php?table=groups&show_users=<?= $row['id_group'] ?>"><?= $row['group_name'] ?></a></td>
                            <td class="table_cell"><?= $row['group_fullname'] ?></td>
                            <td class="table_cell"><?= $row['year_graduate'] ?></td>
                            <td class="table_cell">
                                <!-- =============== SVG РЕДАКТИРОВАНИЕ =============== -->
                                <a href="?table=groups&edit=<?= $row['id_group'] ?>" name="edit" class="table_btn">
                                    <svg class="icon pd-left-3 ">
                                        <use href="./assets/images/svg/sprites.svg#edit" />
                                    </svg>
                                </a>
                                <!-- =============== SVG УДАЛЕНИЕ =============== -->
                                <a href="?table=groups&delete=<?= $row['id_group'] ?>" name="delete" class="table_btn" onclick=" return showConfirmation();">
                                    <svg class="icon pd-left-3 ">
                                        <use href="./assets/images/svg/sprites.svg#delete" />
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
                        pagination($num_rows, $total_pages, "/table.php?table=groups&page");
                        ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    </form>
</div>