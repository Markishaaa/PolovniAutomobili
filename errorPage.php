<?php
    include_once("components.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Error</title>
</head>
<body>
    <?php
        echo navbar();
    ?>

    <div class="message error">You're not logged in!</div>
</body>
</html>