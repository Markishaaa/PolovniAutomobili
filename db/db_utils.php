<?php
    require_once("constants.php");
    require_once("classes/User.php");

    class Database {

        private $hashing_salt = "dsaf7493^&$(#@Kjh";

        private $conn;

        public function __construct($configFile = "config.ini") {
            if($config = parse_ini_file($configFile)) {
				$host = $config["host"];
				$database = $config["database"];
				$user = $config["user"];
				$password = $config["password"];
				$this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
			} else {
                exit("Missing configuration file.");
            }

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function __destruct() {
	    	$this->conn = null;
	    }

        public function getUser($username, $email) {
            $sql = "SELECT * FROM " . TBL_USER . " WHERE " . COL_USER_USERNAME . " LIKE :username OR " . COL_USER_EMAIL . " LIKE :email";
            try {
                $st = $this->conn->prepare($sql);
                $st->bindValue(":username", $username);
                $st->bindValue(":email", $email);
                $st->execute();

                $st->setFetchMode(PDO::FETCH_ASSOC);
                return $st->fetchAll();
            } catch (PDOException $e) {
                return array();
            }
        }

        public function registerUser($email, $username, $password) {
            $u = $this->getUser($username, $email);

            if (!empty($u)) {
                return false;
            }

            $sql = "INSERT INTO " . TBL_USER . " (" . COL_USER_USERNAME . ", " .  COL_USER_EMAIL . ", " . COL_USER_PASSWORD . ", " . COL_USER_MODERATOR . ") VALUES (:username, :email, :password, :moderator);";
            $password_hash = crypt($password, $this->hashing_salt);
            try {
                $st = $this->conn->prepare($sql);
                $st->bindValue(":username", $username);
                $st->bindValue(":password", $password_hash);
                $st->bindValue(":email", $email);
                $st->bindValue(":moderator", 0);
                $st->execute();
            } catch (PDOException $e) {
                echo $e;
				return false;
			}
			return true;
        }

        public function login($username, $password) {
            $u = $this->getUser($username, "");

            if (empty($u)) {
                return false;
            }

            $password_hash = crypt($password, $this->hashing_salt);
            $sql = "SELECT * FROM " . TBL_USER . " WHERE " . COL_USER_USERNAME . " LIKE :username AND " . COL_USER_PASSWORD . " LIKE :password";
            try {
                $st = $this->conn->prepare($sql);
                $st->bindValue("username", $username);
                $st->bindValue("password", $password_hash);
                $st->execute();

                return $st->fetch();
            } catch (PDOException $e) {
                return null;
            }
        }

        public function addCar($fuelId, $bodyId, $manufactId, $year, $price, $description, $isNew, $imgUrl, $phoneNumber, $email, $model) {
            try {
                $username = $_COOKIE["username"];
                $sql = "INSERT INTO " . TBL_CAR_INFO . " ("
                        . CCI_FUEL_ID . ", " . CCI_CAR_BODY_ID . ", "
                        . CCI_MANUFACTURER_ID . ", " . CCI_YEAR . ", "
                        . CCI_PRICE . ", " . CCI_DESCRIPTION . ", "
                        . CCI_IS_NEW . ", " . CCI_IMAGE_URL . ", "
                        . CCI_PHONE_NUMBER . ", " . CCI_USERNAME  . ", "
                        . CCI_EMAIL . ", " . CCI_MODEL . ")"
                        . "VALUES (:fuelId, :bodyId, :manufactId, :year, :price, :description, :isNew, :imgUrl, :phoneNumber, :username, :email, :model)";

                $st = $this->conn->prepare($sql);
                $st->bindValue("fuelId", $fuelId, PDO::PARAM_INT);
                $st->bindValue("bodyId", $bodyId, PDO::PARAM_INT);
                $st->bindValue("manufactId", $manufactId, PDO::PARAM_INT);
                $st->bindValue("year", $year, PDO::PARAM_INT);
                $st->bindValue("price", $price);
                $st->bindValue("description", $description, PDO::PARAM_STR);
                $st->bindValue("isNew", $isNew, PDO::PARAM_BOOL);
                $st->bindValue("imgUrl", $imgUrl, PDO::PARAM_STR);
                $st->bindValue("phoneNumber", $phoneNumber, PDO::PARAM_INT);
                $st->bindValue("username", $username, PDO::PARAM_STR);
                $st->bindValue("email", $email, PDO::PARAM_STR);
                $st->bindValue("model", $model, PDO::PARAM_STR);

                $st->execute();
                return true;
            } catch (PDOException $e) {
                echo $e;
                return false;
            }
        }

        public function deletePost($id) {
            $sql = "DELETE FROM " . TBL_CAR_INFO . " WHERE " . CCI_ID . " LIKE :id";
            try {
				$st = $this->conn->prepare($sql);
				$st->bindValue(":id", $id);
				$st->execute();
			
                return true;
            } catch (PDOException $e) {
				return false;
			}
	    }

        public function getAll($tableName) {
            try {
                $sql = "SELECT * FROM " . $tableName;
                $st = $this->conn->prepare($sql);
                $st->execute();

                $st->setFetchMode(PDO::FETCH_ASSOC);
                return $st->fetchAll();
            } catch (PDOException $e) {
                return array();
            }
        }

        public function getUserPosts() {
            try {
                $sql = "SELECT * FROM " . TBL_CAR_INFO;
                $st = $this->conn->prepare($sql);
                $st->execute();

                $st->setFetchMode(PDO::FETCH_ASSOC);
                return $st->fetchAll();
            } catch (PDOException $e) {
                return array();
            }
        }

        public function getAllPosts() {
            try {
                $username = $_COOKIE["username"];
                $sql = "SELECT * FROM " . TBL_CAR_INFO . " WHERE " . CCI_USERNAME . " LIKE :username";
                $st = $this->conn->prepare($sql);
                $st->bindValue("username", $username, PDO::PARAM_STR);
                $st->execute();

                $st->setFetchMode(PDO::FETCH_ASSOC);
                return $st->fetchAll();
            } catch (PDOException $e) {
                return array();
            }
        }

        public function getById($id, $table) {
            try {
                $sql = "SELECT * FROM " . $table . " WHERE Id LIKE :id";
                $st = $this->conn->prepare($sql);
                $st->bindValue("id", $id);
                $st->execute();

                $st->setFetchMode(PDO::FETCH_ASSOC);
                return $st->fetch();
            } catch (PDOException $e) {
                return null;
            }
        }

    }
?>