<?php
    if (isset($_COOKIE["username"])) {
        setcookie("username", "", time() - 1);
        session_start();
        session_destroy();
        setcookie("PHPSESSID", "", time() - 1);
        header("Location: index.php");
    }
?>