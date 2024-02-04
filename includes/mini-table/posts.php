</div>
<div class="table-mini">
    <h3 class="table-mini_title">Недавние добавления</h3>
    <table class="table-mini_content">
        <thead class=" table_block">
            <tr class="table_row fz-10">
                <th class="table_cell id">ID</th>
                <th class="table_cell post-desc">Описание</th>
                <th class="table_cell created-at">Дата</th>
                <th class="table_cell author">Автор</th>
            </tr>
        </thead>
        <tbody class="table_block">
            <?php
            $select_posts = "SELECT posts.id_post, posts.description, DATE_FORMAT(posts.time, '%d.%m.%y') AS post_time, users.name, users.surname
            FROM posts JOIN users ON posts.id_user = users.id_user ORDER BY id_post DESC LIMIT 5;";
            if (mysqli_query($connection, $select_posts)) {
                $result_selected_posts = mysqli_query($connection, $select_posts);
                while ($row = mysqli_fetch_assoc($result_selected_posts)) {
            ?>
                    <tr class="table_row fz-10">
                        <td class="table_cell id"><?= $row['id_post'] ?></td>
                        <td class="table_cell"><?= $row['description'] ?></td>
                        <td class="table_cell"><?php echo substr($row['post_time'], 0, 10); ?></td>
                        <td class="table_cell"><?php echo $row['name'] . " "  . $row['surname'] ?></td>

                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <h3 class="table-mini_title bottom-border">Граница</h3>

</div>