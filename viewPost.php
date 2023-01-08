<?php
    require_once "db/db_utils.php";
    require_once "components.php";
    require_once "db/constants.php";
    require_once "classes/CarPost.php";

    $db = new Database();

    session_start();
    $u;
    if (isset($_SESSION["user"])) {
        $u = unserialize($_SESSION["user"]);
    }

    $postDb;
    if (isset($_GET["id"])) {
        $postDb = $db->getById($_GET["id"], TBL_CAR_INFO, "*");
    }

    $post = new CarPost($postDb);

    $isNew;
    if ($post->isNew()) {
        $isNew = "New";
    } else {
        $isNew = "Used";
    }

    if (isset($_POST["delete"])) {
        $success = $db->deletePost($post->getId());
        if ($success)
            header("Location: index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/post.css">
    <title><?php echo $post->getManufacturerName() . " " . $post->getModel() ?></title>
</head>
<body>
    <?php
        echo navbar();
    ?>  

    <div class="wrapper">
        <div class="view-wrapper">
            <?php 
                if ($u->isMod() || $u->getUsername() == $post->getUsername()):
            ?>
                    <form method="post">
                        <input type="submit" name="delete" value="[delete post]" class="delete">
                    </form>
            <?php
                endif;
            ?>
            <h1><?php echo $post->getManufacturerName() . " " . $post->getModel() ?><span>(<?php echo $post->getYear() ?>.)<span><?php echo $post->getPrice(); ?>€</span></span></span></h1>
            <div class="wrapper">
                <img src="<?php echo $post->getImgUrl() ?>" alt="picAlt">
            </div>

            <h3>Information:</h3>
            <p>Manufacturer: <?php echo $post->getManufacturerName(); ?></p> <hr>
            <p>Model: <?php echo $post->getModel(); ?></p> <hr>
            <p>New or used: <?php echo $isNew ?></p> <hr>
            <p>Fuel: <?php echo $post->getFuelType(); ?></p> <hr>
            <p>Body: <?php echo $post->getBodyType(); ?></p> <hr>
            <h3>Other information: </h3>
            <p><?php echo $post->getDescription(); ?></p> <hr>
            <h3>Contact info:</h3>
            <p>Phone number: <?php echo $post->getPhoneNumber(); ?></p> 
            <?php 
                if ($post->getEmail() != null):
            ?>
                    <hr>
                    <p>Email: <?php echo $post->getEmail(); ?></p> 
            <?php
                endif;
            ?>

        </div>
    </div>
</body>
</html>