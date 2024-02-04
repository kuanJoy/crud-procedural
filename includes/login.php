<?php
session_start();

if (isset($_SESSION['authorized'])) {
    header("Location: index.php");
    exit();
}


if (isset($_POST['login'])) {
    $email = clear_input($_POST['users']['email']);
    $password = clear_input($_POST['users']['pass']);

    $user = select_email($email);
    if ($user) {
        if ($row = mysqli_fetch_assoc($user)) {
            if ($email == $row['email']) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['authorized'] = true;
                    $_SESSION['id_user'] = $row['id_user'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['surname'] = $row['surname'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['photo'] = $row['photo'];
                    $_SESSION['group'] = $row['group_name'];
                    $_SESSION['year_graduate'] = $row['year_graduate'];
                    $_SESSION['id_role'] = $row['id_role'];
                    header("Location: index.php");
                    exit();
                } else {
                    $_POST['error_pass'] = "Неверный пароль";
                }
            }
        } else {
            $_POST['error_email'] = "Такой почты не существует";
        }
    }
}


?>
<div class="register">
    <h3 class="register__title">Вход</h3>
    <?php
    if (isset($_POST['added'])) {
        echo $_POST['added'];
    }
    ?>
    <form class="login" action="" method="post">
        <?php if (isset($_POST['error_email'])) { ?>
            <span class="alert"><?= $_POST['error_email']; ?></span>
        <?php } ?>
        <label class="login__label" for="">Введите почту:</label>
        <input class="login__input" type="text" name="users[email]">
        <?php if (isset($_POST['error_pass'])) { ?>
            <span class="alert"><?= $_POST['error_pass']; ?></span>
        <?php } ?>
        <label class="login__label" for="">Введите пароль:</label>
        <input class="login__input" type="password" name="users[pass]">
        <button type="submit" class="my-btn" name="login">Войти</button>
        <a class="login-exist" href="/register.php">Создать аккаунт</a>
    </form>
</div>