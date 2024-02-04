    <div class="main_content">
        <h3 class="table-mini_title">Группа <?php
                                            $group_id = $_GET['show_users'];
                                            $take_group_name = "SELECT groups.group_name, groups.year_graduate FROM groups WHERE `id_group` = $group_id";
                                            $query_take_group_name = mysqli_query($connection, $take_group_name);
                                            $take_id = mysqli_fetch_assoc($query_take_group_name);
                                            $group_name = $take_id['group_name'];
                                            $year_grad = $take_id['year_graduate'];
                                            echo $group_name . "-" . substr(strval($year_grad), 2, 4);
                                            ?> </h3>
        <form action="" method="post">
            <table class="table">
                <thead class="table_block">
                    <tr class="table_row">
                        <th class="table_cell id"><a href="/table.php?table=users&sort=id_user">ID</a></th>
                        <th class="table_cell name">Имя</th>
                        <th class="table_cell surname">Фамилия</th>
                        <th class="table_cell email">Почта</th>
                        <th class="table_cell group">Роль</th>
                    </tr>
                </thead>
                <tbody class="table_block">
                    <?php
                    // ПОДКЛЮЧАЕТСЯ ТОЛЬКО К table/groups.php
                    // Если id_role, id_group это единственное общее имя столбца в users roles и groups, вы можете использовать NATURAL JOIN
                    $show_users_by_group = "SELECT users.id_user, users.name, users.surname, users.email, roles.role_name, groups.group_name, groups.year_graduate FROM users
                    NATURAL JOIN roles
                    NATURAL JOIN groups
                    WHERE `id_group` = $group_id";
                    $query_show_users_by_group_result = mysqli_query($connection, $show_users_by_group);
                    if (mysqli_num_rows($query_show_users_by_group_result) > 0) {
                        while ($row = mysqli_fetch_assoc($query_show_users_by_group_result)) { ?>
                            <tr class="table_row">
                                <td class="table_cell id"><?= $row['id_user'] ?></td>
                                <td class="table_cell"><?= $row['name'] ?></td>
                                <td class="table_cell"><?= $row['surname'] ?></td>
                                <td class="table_cell"><?= $row['email'] ?></td>
                                <td class="table_cell"><?= $row['role_name'] ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else {
                        echo "<span class='alert'>В группе отсутствуют студенты</span>";
                    } ?>
                </tbody>
            </table>
        </form>
    </div>