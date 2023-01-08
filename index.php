<?php
    require_once "db/db_utils.php";
    require_once "components.php";
    require_once "classes/CarPost.php";

    $db = new Database();

    $dbPosts;
    $message;
    if (isset($_GET["yourPosts"])) {
        $dbPosts = $db->getUserPosts();
    } else {
        $dbPosts = $db->getAllPosts();
    }

    if (empty($dbPosts)) {
        $message = "No posts to show.";
    }

    $posts = array();
    foreach($dbPosts as $key => $val) {
        $posts[] = new CarPost($val);
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
    <title>Secondhand Cars</title>
</head>
<body>
    <?php
        echo navbar();

        include("search.php"); 
    ?>      

    <div class="wrapper">
        <div class="card-wrapper">
            <?php
                if (!empty($message)):
            ?> 
                    <h1>
                        <?php echo $message ?>
                    </h1>
            <?php
                endif;
            ?>

            <?php 
                foreach($posts as $k => $p):
            ?>
                    <a href="viewPost.php?id=<?php echo $p->getId(); ?>" class="card">
                        <img src="<?php echo $p->getImgUrl() ?>" alt="picAlt">
                        <div class="container2">
                            <?php
                                echo "<h4 class=\"name\">".$p->getManufacturerName()."\t".$p->getModel()."</h4>";
                                echo "<h4>".$p->getPrice()."€<span class=\"year\">Year: ".$p->getYear()."</span></h4>";
                            ?>
                        </div>
                    </a>
            <?php
                endforeach;
            ?>
        </div>
    </div>

</body>
</html>