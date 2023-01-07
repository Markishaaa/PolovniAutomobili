<?php
    require_once "db/db_utils.php";
    require_once "components.php";

    session_start();
    $u;
    if (isset($_SESSION["user"])) {
        $u = unserialize($_SESSION["user"]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Polovni automobili</title>
</head>
<body>
    <?php
        echo navbar();

        if (!empty($u)) {
            echo $u->getUsername();
            echo $u->isMod();
        }
    ?>

</body>
</html>