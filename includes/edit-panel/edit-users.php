<?php if (isset($_GET['edit'])) { ?>
    <h3 class="sbar__title">
        Панель управления студентами
    </h3>
    <div class="sbar__panel">
        <?php
        $errors = [];
        $select_user = "SELECT users.id_user, users.name, users.surname, users.email, users.photo, groups.group_name, groups.year_graduate, roles.id_role, roles.role_name
        FROM users
        JOIN groups ON users.id_group = groups.id_group
        JOIN roles ON users.id_role = roles.id_role
        WHERE users.id_user = {$_GET['edit']}";
        if ($result_select_user = mysqli_query($connection, $select_user)) { ?>
            <?php while ($row = mysqli_fetch_assoc($result_select_user)) { ?>
                <form class="edit-form" method="post" enctype="multipart/form-data">
                    <div class="create_row">
                        <input type="hidden" name="user[id_user]" value="<?= $row['id_user'] ?>">
                        <label class="row_label " for="">Имя:</label>
                        <input class="row_input" type="text" name="user[name]" value="<?= $row['name'] ?>">

                    </div>
                    <div class="create_row">
                        <label class="row_label " for="">Фамилия:</label>
                        <input class="row_input" type="text" name="user[surname]" value="<?= $row['surname'] ?>">

                    </div>
                    <div class="create_row">
                        <label class="row_label " for="">Почта:</label>
                        <input class="row_input" type="text" name="user[email]" value="<?= $row['email'] ?>">
                        <?php
                        $_POST['user']['old_email'] = $row['email'];
                        ?>

                    </div>
                    <div class="create_row">
                        <label class="row_label " for="">Группа:</label>
                        <input class="row_input" type="text" name="user[group_name]" value="<?= $row['group_name'] ?>">

                    </div>
                    <div class="create_row">
                        <label class="row_label " for="">Год выпуска:</label>
                        <input class="row_input" type="text" name="user[year_graduate]" value="<?= $row['year_graduate'] ?>">
                    </div>
                    <div class="create_row">
                        <label class="row_label " for="">Роль:</label>
                        <?php
                        if ($row['role_name'] == 'модератор') { ?>
                            <span>модератор</span><input class="row_input" type="radio" name="user[role]" checked value="2">
                            <span>студент</span><input class="row_input" type="radio" name="user[role]" value="3">
                        <? } else { ?>
                            <span>студент</span><input class="row_input" type="radio" name="user[role]" checked value="3">
                            <span>модератор</span><input class="row_input" type="radio" name="user[role]" value="2">
                        <?php } ?>
                    </div>
                    <div class="create_row d-block">
                        <label class="row_label" for="">Фото:</label>
                        <label for=" ">
                            <span class="df w-0">
                                Оставить прежнее
                                <input type="radio" checked name="user[photo]" value="<?= $row['photo'] ?>" <?= ($row['photo'] === "./assets/images/upload/default_ava.jpg") ? 'checked' : '' ?>>
                            </span>
                            <?php if ($row['photo'] !== "./assets/images/upload/default_ava.jpg") { ?>
                                <span class="df">Установить обычное фото
                                    <input type="radio" name="user[photo]" value="./assets/images/upload/default_ava.jpg">
                                </span>
                            <?php } ?>
                        </label>
                        <span>Загрузить новое
                            <div class="form_photo">
                                <svg class="camera" height="23" width="23" viewBox="0 0 512 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z" />
                                </svg>
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                <input type="file" name="photo">
                            </div>
                        </span>
                        <input type="hidden" name="user[old_photo]" value="<?= $row['photo'] ?>">
                    </div>

                    <button type="submit" name="make_edit" class="my-btn">Изменить</button>
                </form>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    </div>
    </div>