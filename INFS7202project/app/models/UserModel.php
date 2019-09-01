<?php

    /**
     * Handles all user registration and login
     */
    class UserModel {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function registerUser($data) {
            $this->db->query('INSERT INTO users (id,username,email,password,verify_code,activated) VALUES(:id,:username,:email,:password,:verify_code,:activated)');
            $this->db->bind(':id', NULL);
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':verify_code', $data['verify_code']);
            $this->db->bind(':activated',0);
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function login($username, $password) {
            $this->db->query('SELECT * FROM users WHERE username = :username');
            $this->db->bind(':username', $username);
            $row = $this->db->single();
            if ($row == NULL) {
                return false;
            }
            $hashed_password = $row->password;
            if(password_verify($password, $hashed_password)) {
                return $row;
            } else {
                return false;
            }
        }

        public function findUserByEmail($email) {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function findUserByUsername($username) {
            $this->db->query('SELECT * FROM users WHERE username = :username');
            $this->db->bind(':username', $username);
            $row = $this->db->single();
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function getUser($uid){
            $this->db->query('SELECT * FROM users WHERE id = :id');
            $this->db->bind(':id', $uid);
            return $this->db->single();
        }
    }
