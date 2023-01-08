<?php
    require_once "db/db_utils.php";
    require_once "components.php";
    require_once "db/constants.php";

    global $posts;
    $filteredPosts = array();

    $fuels = $db->getAll(TBL_FUEL);
    $bodies = $db->getAll(TBL_CAR_BODY);
    $manufacturers = $db->getAll(TBL_MANUFECTURER);

    if (isset($_GET["search"])) {
        $manuf = $_GET["manufacturer"];
        // if ($manuf != -1) {
        //     foreach ($posts as $k => $p) {
        //         if ($p->getManufacturerName() == $manuf) {
        //             $filteredPosts[] = $p;
        //         }
        //     }
        // }

        $fuel = $_GET["fuel"];
        // if ($fuel != -1) {
        //     foreach ($posts as $k => $p) {
        //         if ($p->getFuelType() == $fuel) {
        //             $filteredPosts[] = $p;
        //         }
        //     }
        // }

        $isNew = $_GET["isNew"];

        $price = PHP_INT_MAX;
        if ($_GET["price"] != null) {
            $price = $_GET["price"];
        }

        foreach ($posts as $k => $p) {
            if (($isNew != "all" && $p->isNew() == $isNew) 
                || ($fuel != "all" && $p->getFuelType() == $fuel)
                || ($manuf != "all" && $p->getManufacturerName() == $manuf)) {
                $filteredPosts[] = $p;
            } else if ($p->getPrice() <= $price) {
                $filteredPosts[] = $p;
            }
        }
        if (!empty($filteredPosts))
            $posts = $filteredPosts;
    }
?>

<head>
    <link rel="stylesheet" href="css/search.css">
</head>

<div class="wrapper">
    <form method="get" class="search">
        <h2>Search</h2>
        <select name="manufacturer">
            <option value="all">all manufacturers</option>
            <?php
                foreach ($manufacturers as $id => $a) {
                    echo "<option value=\"".$a["name"]."\">" . $a["name"] . "</option>";
                }
            ?>
        </select>

        <input type="text" name="price" pattern="^[0-9]*$" placeholder="max price in euros">

        <select name="fuel">
            <option value="all">all types of fuel</option>
            <?php
                foreach ($fuels as $id => $a) {
                    echo "<option value=\"".$a["type"]."\">" . $a["type"] . "</option>";
                }
            ?>
        </select>

        <select name="isNew">
            <option value="all">Used and New</option>
            <option value="0">Used</option>
            <option value="1">New</option>
        </select>

        <input type="submit" name="search" value="Filter" class="btn">
    </form>
</div>