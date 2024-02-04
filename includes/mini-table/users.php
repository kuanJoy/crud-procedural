</div>
<div class="table-mini">
    <h3 class="table-mini_title">Недавние добавления</h3>
    <table class="table-mini_content">
        <thead class=" table_block">
            <tr class="table_row fz-10">
                <th class="table_cell id">ID</th>
                <th class="table_cell name">Имя</th>
                <th class="table_cell surname">Фамилия</th>
                <th class="table_cell email">Почта</th>
                <th class="table_cell group">Группа</th>
            </tr>
        </thead>
        <tbody class="table_block">
            <?php
            $select_users = "SELECT users.id_user, users.name, users.surname, users.email, groups.group_name 
            FROM users JOIN groups ON users.id_group = groups.id_group ORDER BY id_user DESC LIMIT 5;";
            if (mysqli_query($connection, $select_users)) {
                $result_selected_users = mysqli_query($connection, $select_users);
                while ($row = mysqli_fetch_assoc($result_selected_users)) { ?>
                    <tr class="table_row fz-10">
                        <td class="table_cell id"><?= $row['id_user'] ?></td>
                        <td class="table_cell"><?= $row['name'] ?></td>
                        <td class="table_cell"><?= $row['surname'] ?></td>
                        <td class="table_cell"><?= $row['email'] ?></td>
                        <td class="table_cell"><?= $row['group_name'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <h3 class="table-mini_title bottom-border">Граница</h3>
</div>