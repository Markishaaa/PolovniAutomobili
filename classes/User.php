<?php
    class User {
        private $email;
        private $username;
        private $mod;

        public function __construct($arr) {
            if (!empty($arr)) {
                $this->email = $arr["email"];
                $this->username = $arr["username"];
                $this->mod = $arr["moderator"];
            }
        }

        public function getEmail() {
            return $this->email;
        }

        public function getUsername() {
            return $this->username;
        }

        public function isMod() {
            return $this->mod;
        }
    }
?>