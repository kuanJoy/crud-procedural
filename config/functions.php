<?php
function clear_input($input)
{
    return trim(htmlentities($input));
}

// FOR includes/login.php
function select_email($email)
{
    global $connection;
    $query = "SELECT users.id_user, users.name, users.surname, users.password, users.email, users.photo, users.id_role, groups.group_name, groups.year_graduate FROM users 
    JOIN groups ON users.id_group = groups.id_group 
    WHERE users.email = '$email'";
    $result_query = mysqli_query($connection, $query);
    if ($result_query) {
        return $result_query;
    } else {
        return false;
    }
}


function execute_query($connect, $query, $params = null)
{
    $stmt = mysqli_prepare($connect, $query);

    if ($params) {
        mysqli_stmt_bind_param($stmt, ...$params);
    }

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}



function pagination($query, $total_pages, $link)
{
    if (mysqli_num_rows($query) > 1) {
        global $page;
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<a class='current-page'>$i</a>";
            } else {
                echo "<a class='pages' href='$link=$i'>$i</a>";
            }
        }
    }
}


function show_errors()
{
    global $errors;
    if (isset($errors)) {
        foreach ($errors as $error) {
            echo "<span class='alert'>$error;</span>";
        }
    }
}


function validate_email()
{
    global $user_email;
    if (empty($user_email)) {
        $errors['email'] = 'Введите почту;';
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Некорректная почта;';
    }
}
