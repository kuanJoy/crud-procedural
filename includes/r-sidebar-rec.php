<?php
$select_top_authors = "SELECT posts.status, users.id_user, users.name, users.surname, COUNT(*) AS count 
                                        FROM posts 
                                        JOIN users ON users.id_user = posts.id_user 
                                        WHERE posts.status = 1
                                        GROUP BY posts.id_user
                                        HAVING count > 1 
                                        ORDER BY count DESC 
                                        LIMIT 15;
                                    ";
$select_top_groups = "SELECT groups.id_group, groups.group_name, groups.year_graduate, posts.id_post, COUNT(posts.id_post) AS post_count 
                            FROM groups
                            JOIN users ON groups.id_group = users.id_group
                            JOIN posts ON users.id_user = posts.id_user
                            WHERE posts.status = 1
                            GROUP BY groups.id_group
                            HAVING post_count > 1 
                            ORDER BY post_count DESC
                            LIMIT 10;";

$show_top_authors = mysqli_query($connection, $select_top_authors);
$show_top_groups = mysqli_query($connection, $select_top_groups);

if (isset($show_top_authors) && isset($show_top_groups)) {
?>
    <div class="right-sidebar">
        <div class="sbar__rec">
            <h3 class="sbar__rec_title">
                Рекомендации
            </h3>
            <?php if (mysqli_num_rows($show_top_authors) > 0) { ?>
                <div class="sbar__rec_content">
                    <span class="sbar__rec_content_title">Топ авторов: </span>
                    <?php
                    while ($row = mysqli_fetch_array($show_top_authors)) { ?>
                        <div class="sbar__rec_content_item">

                            <a href="home.php?author=<?= $row['id_user'] ?>" class="sbar__rec_content_author"><?= $row['name'] . " " . $row['surname'] ?> </a>
                            <span class="sbar__rec_content_count"><?= $row["count"] ?></span>
                        </div> <?php } ?>
                <?php } ?>
            <?php } ?>
                </div>
                <?php if (mysqli_num_rows($show_top_groups) > 0) { ?>
                    <div class="sbar__rec_content">
                        <span class="sbar__rec_content_title">Топ групп по цитатам: </span>
                        <?php
                        while ($row_groups = mysqli_fetch_array($show_top_groups)) { ?>
                            <div class="sbar__rec_content_item">
                                <a href="home.php?group=<?= $row_groups['id_group'] ?>" class="sbar__rec_content_author"><?= $row_groups['group_name'] . "-" . substr(strval($row_groups['year_graduate']), 2, 4) ?> </a>
                                <span class="sbar__rec_content_count"><?= $row_groups["post_count"] ?></span>
                            </div> <?php } ?>
                    </div>
                <?php } ?>
        </div>
    </div>
    </main>
    </div>
    <script src="./assets/js/script.js"></script>
    </body>

    </html>