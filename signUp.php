<?php
    require_once "components.php";
    require_once "db/db_utils.php";

    $db = new Database();

    $success;
    if (isset($_POST["register"])) {
        $email = htmlspecialchars($_POST["email"]);
        $username = htmlspecialchars($_POST["username"]);
        $password_hash = htmlspecialchars(password_hash($_POST["password"], PASSWORD_DEFAULT));

        $success = $db->registerUser($email, $username, $password_hash);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <title>Sign Up</title>
</head>
<body>
    <?php
        echo navbar();      
    ?>

    <div class="wrapper">
        <div class="box">
            <h1>Login</h1>

            <input type="text" placeholder="Username">
            <input type="password" placeholder="Password">
            <label class="main">Remember me
                <input type="checkbox">
                <span class="checkbox"></span>
            </label>
            <input type="submit" value="Sign In" class="btn login-btn">
        </div>
        <div class="box">
            <h1>Register</h1>
            <form method="post" action="">
                <input type="email" name="email" placeholder="Email">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" name="register" value="Sign Up" class="btn">
            </form>
        </div>
    </div>
</body>
</html>