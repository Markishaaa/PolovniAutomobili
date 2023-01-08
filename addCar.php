<?php
    require_once "db/db_utils.php";
    require_once "components.php";
    require_once "db/constants.php";

    if (!isset($_COOKIE["username"])) {
        header("Location: errorPage.php");
    }

    $db = new Database();
    $message;
    $message2;
    $messageType;

    $fuels = $db->getAll(TBL_FUEL);
    $bodies = $db->getAll(TBL_CAR_BODY);
    $manufacturers = $db->getAll(TBL_MANUFECTURER);

    session_start();
    $u;
    if (isset($_SESSION["user"])) {
        $u = unserialize($_SESSION["user"]);
    }

    if (isset($_POST["add"])) {
        $fuelId = $_POST["fuel"];
        $carBodyId = $_POST["body"];
        $manufacturerId = $_POST["manufacturer"];
        $year = $_POST["year"];
        $price = $_POST["price"];
        $description = $_POST["description"];
        $isNew = $_POST["isNew"];
        $imageUrl = uploadFile();
        $phoneNumber = $_POST["phone"];
        $email = null;
        $model = $_POST["model"];

        if (!empty($_POST["email"])) {
            $email = $u->getEmail();
        }

        $success = $db->addCar($fuelId, $carBodyId, $manufacturerId, $year, 
            $price, $description, $isNew, $imageUrl, $phoneNumber, $email, $model);
        
        if ($success) {
            $message = "Post successfully created.";
            $messageType = "success";
        } else {
            $message = "Post creation unsuccessful.";
            $messageType = "error";
        }
    }

    function uploadFile() {
        global $message2;
        global $messageType;

        $file = $_FILES["pic"];
        $getExt = explode('.', $file["name"]);
        $fileExt = strtolower(end($getExt));
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($fileExt, $allowed)) {
            if ($file["error"] === 0) {
                if ($file["size"] < 15*MB) {
                    $fileName = uniqid('', true) . $fileExt;
                    $fileDest = "res/" . $fileName;
                    move_uploaded_file($file["tmp_name"], $fileDest);

                    return $fileDest;
                } else {
                    $message2 = "Your file is too big. You can upload files up to 15mb."; 
                    $messageType = "error";  
                }
            } else {
               $message2 = "There was an error uploading your file."; 
               $messageType = "error";
            }
        } else {
            $message2 = "You can only upload files of type: jpg, jpeg, png.";
            $messageType = "error";
        }

        return null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <title>Add a car</title>
</head>
<body>
    <?php
        echo navbar();
    ?>

    <?php
        if (!empty($message) || !empty($message2)):
    ?> 
            <div class="message <?php echo $messageType ?>">
                <?php echo $message ?>
                <?php echo $message2 ?>
            </div>
    <?php
        endif;
    ?>

    <div class="outer">
        <form method="post" enctype="multipart/form-data" class="wrapper">
            <h1>Create a post</h1>

            <label>Manufacturer</label>
            <select name="manufacturer">
                <?php
                    foreach ($manufacturers as $id => $a) {
                        echo "<option value=\"".$a["id"]."\">" . $a["name"] . "</option>";
                    }
                ?>
            </select>

            <label>Model</label>
            <input type="text" name="model" required>

            <label>Type of body</label>
            <select name="body">
                <?php
                    foreach ($bodies as $id => $a) {
                        echo "<option value=\"".$a["id"]."\">" . $a["type"] . "</option>";
                    }
                ?>
            </select>
            
            <label>Type of fuel</label>
            <select name="fuel">
                <?php
                    foreach ($fuels as $id => $a) {
                        echo "<option value=\"".$a["id"]."\">" . $a["type"] . "</option>";
                    }
                ?>
            </select>
            
            <label>Year of manufacture</label>
            <input type="text" name="year" pattern="^[0-9]*$" required>

            <label>Information</label>
            <textarea name="description" class="description"
             placeholder="mileage driven, automatic or stick transmission, car color, number of doors, number of seats..." required></textarea>
            
            <label>Is the car new</label>
            <select name="isNew">
                <option value="0">Used</option>;
                <option value="1">New</option>;
            </select>

            <label>Car picture</label>
            <input type="file" name="pic" class="custom-file-upload" required>

            <label>Price in euros</label>
            <input type="text" name="price" pattern="^[0-9]*$" required>

            <label>Your phone number</label>
            <input type="text" name="phone" pattern="^[0-9]*$" required>
            
            <label class="label-checkbox">Show my email
                <input type="checkbox" name="email">
                <span class="checkbox"></span>
            </label>

            <input type="submit" name="add" value="Submit" class="btn">
        </form>
    </div>
</body>
</html>