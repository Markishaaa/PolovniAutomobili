<?php

    function navbar() {
        if (isset($_COOKIE["username"])) {
            return "
                <nav>
                    <a href=\"index.php\">Polovni automobili</a>
                    <a href=\"logout.php\" class=\"nav-right\">Logout</a>
                    <span class=\"nav-right\"> | </span>
                    <p class=\"nav-right\">" . $_COOKIE["username"] ."</a>
                </nav>";
        } else {
            return <<<HTML
                <nav>
                    <a href="index.php">Polovni automobili</a>
                    <a href="signUp.php" class="nav-right">Sign Up</a>
                </nav>
HTML;
        }
    }

?>