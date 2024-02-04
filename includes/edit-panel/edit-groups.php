<?php if (isset($_GET['edit'])) { ?>
    <h3 class="sbar__title">
        Панель управления группами
    </h3>
    <div class="sbar__panel">
        <?php
        $errors = [];
        $select_group = "SELECT * FROM groups WHERE id_group = {$_GET['edit']}";
        if ($result_select_group = mysqli_query($connection, $select_group)) { ?>
            <?php while ($row = mysqli_fetch_assoc($result_select_group)) { ?>
                <form class="edit-form" method="post">
                    <div class="create_row">
                        <input type="hidden" name="group[id_group]" value="<?= $row['id_group'] ?>">
                        <label class="row_label " for="">Группа:</label>
                        <input class="row_input" type="text" name="group[name]" value="<?= $row['group_name'] ?>">
                    </div>
                    <div class="create_row">
                        <label class="row_label " for="">Название группы:</label>
                        <input class="row_input" type="text" name="group[fullname]" value="<?= $row['group_fullname'] ?>">
                    </div>
                    <div class="create_row">
                        <label class="row_label " for="">Год выпуска:</label>
                        <input class="row_input" type="text" name="group[year]" value="<?= $row['year_graduate'] ?>">
                    </div>
                    <button type="submit" name="make_edit" class="my-btn">Изменить</button>
                </form>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    </div>
    </div>