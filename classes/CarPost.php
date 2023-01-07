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
                $this->isNew = $arr["isNew"];
                $this->imgUrl = $arr["imageUrl"];
                $this->phoneNumber = $arr["phoneNumber"];
                $this->model = $arr["model"];
                $this->email = $arr["email"];

                $this->fuelType = $this->findType($arr["fuelId"], TBL_FUEL, "type");
                $this->bodyType = $this->findType($arr["bodyId"], TBL_CAR_BODY, "type");
                $this->manufacturerName = $this->findType($arr["manufacturerId"], TBL_MANUFECTURER, "name");
                $this->username = $arr["username"];
            }
        }

        private function findType($id, $table, $t) {
            global $db;
            $type = $db->getById($id, $table);
            return $type[$t];
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
            return $this->description;
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

    }
?>