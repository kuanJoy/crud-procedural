</div>
<div class="table-mini">
    <h3 class="table-mini_title">Недавние добавления</h3>
    <table class="table-mini_content">
        <thead class=" table_block">
            <tr class="table_row fz-10">
                <th class="table_cell id ">ID</th>
                <th class="table_cell group ">Группа</th>
                <th class="table_cell ">Название</th>
                <th class="table_cell year-graduate ">Год выпуска</th>
            </tr>
        </thead>
        <tbody class="table_block">
            <?php
            $select_groups = "SELECT * FROM `groups` ORDER BY id_group DESC LIMIT 5";
            if (mysqli_query($connection, $select_groups)) {
                $result_select_groups = mysqli_query($connection, $select_groups);
                while ($row = mysqli_fetch_assoc($result_select_groups)) { ?>
                    <tr class="table_row fz-10">
                        <td class="table_cell id"><?= $row['id_group'] ?></td>
                        <td class="table_cell"><?= $row['group_name'] ?></td>
                        <td class="table_cell"><?= $row['group_fullname'] ?></td>
                        <td class="table_cell"><?= $row['year_graduate'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <h3 class="table-mini_title bottom-border">Граница</h3>
</div>