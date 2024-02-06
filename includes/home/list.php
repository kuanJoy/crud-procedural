<div class="quote-list">
    <?php
    if (isset($_GET['author'])) {
        // СЕЛЕКТИМ ПОСТЫ ПО АВТОРУ
        $id_user = $_GET['author'];
        $select = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.id_user, users.name, users.surname, users.photo, groups.id_group, groups.group_name, groups.year_graduate
            FROM posts JOIN users ON posts.id_user = users.id_user JOIN groups ON users.id_group = groups.id_group WHERE users.id_user = '$id_user'";
    } elseif (isset($_GET['group'])) {
        // СЕЛЕКТИМ ПОСТЫ ПО ГРУППЕ
        $id_groups = $_GET['group'];
        $select = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.id_user, users.name, users.surname, users.photo, groups.id_group, groups.group_name, groups.year_graduate
            FROM posts JOIN users ON posts.id_user = users.id_user JOIN groups ON users.id_group = groups.id_group WHERE groups.id_group = '$id_groups'";
    } else {
        // СЕЛЕКТИМ ВСЕ ПОСТЫ
        $select = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.id_user, users.name, users.surname, users.photo, groups.id_group, groups.group_name, groups.year_graduate
            FROM posts JOIN users ON posts.id_user = users.id_user JOIN groups ON users.id_group = groups.id_group WHERE posts.status = 1 ORDER BY posts.id_post";
    }

    if ($result_select_posts = mysqli_query($connection, $select)) {
        $items_per_page = 5;
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

        if (isset($_GET['author'])) {
            $limit = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.id_user, users.name, users.surname, users.photo, groups.id_group, groups.group_name, groups.year_graduate
            FROM posts JOIN users ON posts.id_user = users.id_user JOIN groups ON users.id_group = groups.id_group 
            WHERE users.id_user = '$id_user' 
            LIMIT $items_per_page OFFSET $start";
        } elseif (isset($_GET['group'])) {
            $limit = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.id_user, users.name, users.surname, users.photo, groups.id_group, groups.group_name, groups.year_graduate
            FROM posts JOIN users ON posts.id_user = users.id_user JOIN groups ON users.id_group = groups.id_group 
            WHERE groups.id_group = '$id_groups' 
            LIMIT $items_per_page OFFSET $start";
        } else {
            $limit = "SELECT posts.id_post, posts.description, posts.status, DATE_FORMAT(posts.time, '%d.%m.%y') AS posts_time, users.id_user, users.name, users.surname, users.photo, groups.id_group, groups.group_name, groups.year_graduate
            FROM posts 
            JOIN users ON posts.id_user = users.id_user 
            JOIN groups ON users.id_group = groups.id_group 
            WHERE posts.status = 1
            ORDER BY posts.id_post
            LIMIT $items_per_page OFFSET $start";;
        }

        $result_limit = mysqli_query($connection, $limit);
        $display = 0;

        while ($row = mysqli_fetch_assoc($result_limit)) {
            if ($display == 0 && isset($_GET['author'])) { ?>
                <div class="quote-list__filter"><span class="filter__item">Фильтр: <?= $row['name'] . " " . $row['surname'] ?></span>
                    <a href="/home.php" class="filter__item">Сбросить фильтр</a>
                </div>
            <? } elseif ($display == 0 && isset($_GET['group'])) { ?>
                <div class="quote-list__filter"><span class="filter__item">Фильтр: <?= $row['group_name'] . "-" . substr(strval($row['year_graduate']), 2, 4) ?></span>
                    <a href="/home.php" class="filter__item">Сбросить фильтр</a>
                </div>
            <?php }
            $display += 1; ?>
            <div class="ql_card">
                <img class="ql_card_photo" src="<?= $row['photo'] ?>">
                <div class="ql_card_content">
                    <p class="ql_card_content__desc">«<?= nl2br($row['description']) ?>»</p>
                    <div class="ql_card_content__info">
                        <a href="?author=<?= $row['id_user'] ?>" class="ql_card_content__info_author"><?php echo $row['name'] . " " . $row['surname'] ?></a>
                        <div class="ql_card_content__info_groups">
                            <a href="?group=<?= $row['id_group'] ?>" class="group"> <?php echo $row['group_name'] . "-" . substr(strval($row['year_graduate']), 2, 4)  ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
    <div class="pagination-list">
        <?php
        function check_get()
        {
            global $id_user;
            global $id_groups;

            if (isset($_GET['author'])) {
                return "/home.php?author=$id_user=&page";
            } elseif (isset($_GET['group'])) {
                return "/home.php?group=$id_groups=&page";
            } else {
                return "/home.php?page";
            }
        }

        pagination($num_rows, $total_pages, check_get());
        ?>
    </div>
</div>