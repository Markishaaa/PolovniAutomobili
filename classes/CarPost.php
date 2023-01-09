<?php
    include_once("db/db_utils.php");
    include_once("db/constants.php");

    $db = new Database();

    class CarPost {

        private $id;
        private $year;
        private $price;
        private $description;
        private $isNew;
        private $imgUrl;
        private $phoneNumber;
        private $model;
        private $email;

        private $fuelType;
        private $bodyType;
        private $manufacturerName;
        private $username;

        public function __construct($arr) {
            if (!empty($arr)) {
                $this->id = $arr["id"];
                $this->year = $arr["year"];
                $this->price = $arr["price"];
                $this->description = $arr["description"];
                $this->isNew = $arr["is_new"];
                $this->imgUrl = $arr["image_url"];
                $this->phoneNumber = $arr["phone_number"];
                $this->model = $arr["model"];
                $this->email = $arr["email"];

                global $db;
                $this->fuelType = $db->getById($arr["fuel_id"], TBL_FUEL, "type")["type"] ?? '?';
                $this->bodyType = $db->getById($arr["car_body_id"], TBL_CAR_BODY, "type")["type"] ?? '?';
                $this->manufacturerName = $db->getById($arr["manufacturer_id"], TBL_MANUFECTURER, "name")["name"] ?? '?';
                $this->username = $arr["user"];
            }
        }

        public function getId() {
            return $this->id;
        }

        public function getYear() {
            return $this->year;
        }

        public function getPrice() {
            return $this->price;
        }

        public function isNew() {
            return $this->isNew;
        }

        public function getDescription() {
            return str_replace("\r\n", "<br>", $this->description);
        }

        public function getImgUrl() {
            return $this->imgUrl;
        }

        public function getPhoneNumber() {
            return $this->phoneNumber;
        }

        public function getModel() {
            return $this->model;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getFuelType() {
            return $this->fuelType;
        }

        public function getBodyType() {
            return $this->bodyType;
        }

        public function getManufacturerName() {
            return $this->manufacturerName;
        }

        public function getUsername() {
            return $this->username;
        }

        public function __toString() {
            return $this->id;
        }

    }
?>