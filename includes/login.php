<?php
session_start();

if (isset($_SESSION['authorized'])) {
    header("Location: index.php");
    exit();
}
$errors = [];

if (isset($_POST['login'])) {
    $email = clear_input($_POST['users']['email']);
    $password = clear_input($_POST['users']['pass']);

    validate_email($errors, $email);

    if (empty($password)) {
        $errors["pass"] = "Введите пароль";
    } else {
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
                        $_SESSION['added'] = null;
                        header("Location: index.php");
                        exit();
                    } else {
                        $errors['error_pass'] = "Неверный пароль";
                    }
                }
            } else {
                $errors['error_email'] = "Такой почты не существует";
            }
        }
    }
}


?>
<div class="register">
    <h3 class="register__title">Вход</h3>
    <?php
    if (isset($_SESSION['added'])) {
        echo "<span style='color:green'>{$_SESSION['added']}</span>";
        unset($_SESSION['added']);
    }
    show_errors();
    ?>
    <form class="login" action="" method="post">
        <label class="login__label" for="">Введите почту:</label>
        <input class="login__input" type="text" name="users[email]">
        <label class="login__label" for="">Введите пароль:</label>
        <input class="login__input" type="password" name="users[pass]">
        <button type="submit" class="my-btn" name="login">Войти</button>
        <a class="login-exist" href="/register.php">Создать аккаунт</a>
    </form>
</div>