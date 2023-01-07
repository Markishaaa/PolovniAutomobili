<?php
    require_once "components.php";
    require_once "db/db_utils.php";
    require_once "classes/User.php";

    $db = new Database();
    $message;
    $messageType;

    if (isset($_COOKIE["username"])) {
        $message = "Successfully logged in.";
        $messageType = "success";
    }

    $user;
    if (isset($_POST["login"])) {
        $username = htmlspecialchars($_POST["lusername"]);
        $password = htmlspecialchars($_POST["lpassword"]);

        $u = $db->login($username, $password);

        if ($u != null) {
            $user = new User($u);

            session_start();
            $_SESSION["user"] = serialize($user);

            if (isset($_POST["rememberMe"])) {
                setcookie("username", $username, time() + 60 * 60 * 24);
            } else {
                setcookie("username", $username, 0);
            }

            header("Location: signUp.php");
        } else {
            $message = "Incorrect username or password.";
            $messageType = "error";
        }       
    }

    $success;
    if (isset($_POST["register"])) {
        $email = htmlspecialchars($_POST["email"]);
        $username = htmlspecialchars($_POST["username"]);
        $password_hash = htmlspecialchars($_POST["password"]);

        $success = $db->registerUser($email, $username, $password_hash);

        if ($success) {
            $message = "Successfully registered";
            $messageType = "success";
        } else {
            $message = "Email or username are already in use.";
            $messageType = "error";
        }
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
                <form method="post" action="">
                <input type="text" name="lusername" placeholder="Username" required>
                <input type="password" name="lpassword" placeholder="Password" required>
                <label class="main">Remember me
                    <input type="checkbox" name="rememberMe">
                    <span class="checkbox"></span>
                </label>
                <input type="submit" name="login" value="Sign In" class="btn login-btn">
            </form>
        </div>

        <div class="box">
            <h1>Register</h1>
            <form method="post" action="">
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="register" value="Sign Up" class="btn">
            </form>
        </div>
    </div>

    <?php
        if (!empty($message)):
    ?> 
            <div class="message <?php echo $messageType ?>">
                <?php echo $message ?>
            </div>
    <?php
        endif;
    ?>

</body>
</html>