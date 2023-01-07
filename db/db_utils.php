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

        

    }
?>