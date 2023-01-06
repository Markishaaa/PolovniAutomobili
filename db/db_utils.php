<?php
    require_once("constants.php");

    class Database {

        private $conn;

        public function __construct($configFile = "db/config.ini") {
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

        public function registerUser($email, $username, $password) {
            $sql = "INSERT INTO " . TBL_USER . " (" . COL_USER_USERNAME . ", " .  COL_USER_EMAIL . ", " . COL_USER_PASSWORD . ", " . COL_USER_MODERATOR . ") VALUES (:Username, :Email, :Password);";
            try {
                $st = $this->conn->prepare($sql);
                $st->bindValue(":username", $username);
                $st->bindValue(":password", $password);
                $st->bindValue(":email", $email);
                $st->execute();
            } catch (PDOException $e) {
				return false;
			}
			return true;
        }

    }
?>