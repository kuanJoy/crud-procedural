<?php
// ========================== СКРИПТ РЕДАКТИРОВАНИЕ ПРОФИЛЯ ==========================
require_once "./includes/profile/edit-profile.php";

// ========================== СКРИПТ СОЗДАНИЕ ПОСТА ==========================
require_once "./includes/profile/create-post.php";

// ========================== СКРИПТ РЕДАКТИРОВАНИЕ ПОСТА ==========================
require_once "./includes/profile/edit-post.php";

//  ========================== СКРИПТ УДАЛЕНИЕ ПОСТА ==========================
require_once "./includes/profile/delete-post.php";


// ========================== СКРИПТ ВЫВОД ПРОФИЛЯ ==========================
$email = $_SESSION['email'];
$select_user = "SELECT users.id_user, users.name, users.surname, users.email, users.photo, groups.group_name, groups.year_graduate, roles.id_role, roles.role_name 
                    FROM users 
                    JOIN groups ON users.id_group = groups.id_group 
                    JOIN roles ON users.id_role = roles.id_role 
                    WHERE users.email = '$email'";
if ($result_select_user = mysqli_query($connection, $select_user)) {
    while ($row = mysqli_fetch_assoc($result_select_user)) { ?>
        <div class="profile_and_actions">
            <div class="profile__content">
                <img class="profile__image" src="<?= $row['photo'] ?>" alt="">
                <div class="profile__info">
                    <div class="profile__rows">
                        <h3 class="profile__row">
                            <?php echo ($row['name'] . " " . $row['surname']); ?>
                        </h3>
                        <h3 class="profile__row">
                            <?php echo ($row['group_name'] . "-" . $row['year_graduate']); ?>
                        </h3>
                        <h3 class="profile__row">
                            <?php echo ($row['email']); ?>
                        </h3>
                    </div>
                    <div class="profile__btns">
                        <a href="?edit_profile=" class="my-btn">Редактировать</a>
                        <a href="?create=" class="my-btn">Добавить цитату</a>
                    </div>
                    <?php
                    show_errors();
                    ?>
                </div>
            </div>
            <?php if (isset($_GET['edit_profile'])) { ?>
                <!-- ==================== ОКНО РЕДАКТИРОВАНИЕ ПРОФИЛЯ ==================== -->
                <div class="right-sidebar">
                    <h3 class="sbar__title">
                        Редактирование профиля
                    </h3>
                    <div class="sbar__panel">

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
                            <button type="submit" name="btn_edit_profile" class="my-btn">Изменить</button>
                        </form>
                    </div>
                </div>
            <?php } elseif (isset($_GET['create'])) { ?>
                <!-- =================================== ОКНО СОЗДАНИЕ ПОСТА =================================== -->
                <div class="right-sidebar">
                    <?php if (isset($_POST['added'])) {
                        echo $_POST['added'];
                    } elseif (isset($error_desc)) {
                        echo $error_desc;
                    }
                    ?>
                    <form class="create b-none" action="" method="post">
                        <div class="create_quote-btns">
                            <textarea class="create_post" name="post[description]"></textarea>
                            <div class="create_btns">
                                <button class="my-btn" name="submitPost" type="submit">Опубликовать</button>
                            </div>
                    </form>
                </div>
        </div>
    <?php } elseif (isset($_GET['edit_post'])) { ?>
        <!-- =================================== ОКНО РЕДАКТИРОВАНИЕ ПОСТА =================================== -->
        <div class="right-sidebar">
            <div class="sbar__panel">
                <?php
                $select_post = "SELECT posts.description, posts.status FROM `posts` WHERE posts.id_post = {$_GET['edit_post']}";
                if ($result_select_post = mysqli_query($connection, $select_post)) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result_select_post)) { ?>
                        <form class="edit-form" method="post">
                            <div class="create_row block">
                                <label class="row_label w-4" for="">описание:</label>
                                <div class="create_quote-btns">
                                    <textarea class="create_post" name="post[desc]"><?= $row['description'] ?></textarea>
                                </div>

                            </div>
                            <div class="post-status">
                                <div class="create_row">
                                    <label class="row_label " for="">Статус:</label>
                                    <?php
                                    if ($row['status'] == 'активен') { ?>
                                        <span class="">активен</span><input checked type="radio" name="post[status]" value="1">
                                        <span>скрыт</span><input type="radio" name="post[status]" value="2">
                                    <?php } else { ?>
                                        <span>скрыт</span><input checked type="radio" name="post[status]" value="2">
                                        <span>активен</span><input type="radio" name="post[status]" value="1">
                                    <?php } ?>
                                </div>

                            </div>
                            <button type="submit" name="btn_edit_post" class="my-btn">Изменить</button>
                        </form>

            </div>
        </div>
    <?php }
                    show_errors(); ?>
<?php } ?>
<?php } ?>
</div>
<div class="profile__posts">
    <div class="quote-list">
        <!-- =================================== ОКНО ВЫВОДА ПОСТОВ ===================================  -->
        <?php
        $select_user_posts = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.id_user, users.name, users.surname, users.photo, groups.id_group, groups.group_name, groups.year_graduate
            FROM posts JOIN users ON posts.id_user = users.id_user JOIN groups ON users.id_group = groups.id_group WHERE users.email = '$email'";

        if ($result_select_posts = mysqli_query($connection, $select_user_posts)) {
            $items_per_page = 3;
            $num_rows = mysqli_num_rows($result_select_posts);
            if ($num_rows > 0) {
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
                $limit = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.id_user, users.name, users.surname, users.photo, groups.id_group, groups.group_name, groups.year_graduate
            FROM posts JOIN users ON posts.id_user = users.id_user 
            JOIN groups ON users.id_group = groups.id_group 
            WHERE users.email = '$email' LIMIT $items_per_page OFFSET $start";

                $result_limit = mysqli_query($connection, $limit);
                while ($row = mysqli_fetch_assoc($result_limit)) { { ?>
                        <div class="ql_card">
                            <div class="ql_card_content p-20">
                                <p class="ql_card_content__desc">«<?= nl2br($row['description']) ?>»</p>
                                <div class="ql_card_content__info">
                                    <p><?php echo substr($row['posts_time'], 0, 8); ?></p>
                                    <a href="profile.php?edit_post=<?= $row['id_post'] ?>">
                                        <svg class="icon pd-left-3 ">
                                            <use href="./assets/images/svg/sprites.svg#edit" />
                                        </svg>
                                    </a>
                                    <a href="profile.php?delete=<?= $row['id_post'] ?>" name="delete" onclick="return showConfirmation()">
                                        <svg class=" icon pd-left-3 ">
                                            <use href=" ./assets/images/svg/sprites.svg#delete" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <div class="pagination-list">
            <?php
            // must have isset для profile.php
            if (isset($total_pages)) {
                pagination($num_rows, $total_pages, "/profile.php?page");
            }
            ?>
        </div>
    </div>
</div>
<?php } ?>
<?php } ?>