<?php if (isset($_GET['edit'])) { ?>
    <h3 class="sbar__title">
        Панель управления студентами
    </h3>
    <div class="sbar__panel">
        <?php
        $errors = [];
        $select_post = "SELECT posts.description, posts.status FROM `posts` WHERE posts.id_post = {$_GET['edit']}";
        if ($result_select_post = mysqli_query($connection, $select_post)) { ?>
            <?php while ($row = mysqli_fetch_assoc($result_select_post)) { ?>
                <form class="edit-form" method="post">
                    <div class="create_row block">
                        <label class="row_label w-4" for="">описание:</label>
                        <div class="create_quote-btns">
                            <textarea class="create_post" name="post[desc]"><?= $row['description'] ?>
                            </textarea>
                        </div>
                        <?php
                        show_errors(); ?>
                    </div>
                    <div class="post-status">
                        <div class="create_row">
                            <label class="row_label " for="">Статус:</label>
                            <?php
                            if ($row['status'] == 'активен') { ?>
                                <span>активен</span><input checked type="radio" name="post[status]" value="1">
                                <span>скрыт</span><input type="radio" name="post[status]" value="2">
                            <?php } else { ?>
                                <span>скрыт</span><input checked type="radio" name="post[status]" value="2">
                                <span>активен</span><input type="radio" name="post[status]" value="1">
                            <?php } ?>
                        </div>
                    </div>
                    <button type=" submit" name="make_edit" class="my-btn">Изменить</button>
                </form>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    </div>
    </div>