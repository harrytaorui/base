<?php

class AccountModel {

	private $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function getCurrentUser() {
		$this->db->query("SELECT * FROM users WHERE username = :username");
		$this->db->bind(':username', $_SESSION['username']);
		return $this->db->single();
	}


	public function updateProfile($data) {

		$this->db->query('UPDATE users SET username = :username, 
			email = :email WHERE id = :id');
		$this->db->bind(':username', $data['username']);
		$this->db->bind(':email', $data['email']);
		$this->db->bind(':id', $data['id']);

		if($this->db->execute()){
			return true;
		}else{
			return false;
		}

	}


	public function activate_account($username){
		$this->db->query('UPDATE users SET activated = :activated WHERE username = :username');
		$this->db->bind(":activated", 1);
		$this->db->bind(":username", $username);
		if($this->db->execute()){
			return true;
		}else{
			return false;
		}
	}


	public function verify_email($username,$verify){
		$this->db->query("SELECT * FROM users WHERE username = :username");
		$this->db->bind(":username", $username);
		$result = $this->db->single();
		if ($result->verify_code == $verify) {
			return $this->activate_account($username);
		}
	}


	public function findUserByEmail($email) {
		$this->db->query("SELECT * FROM users WHERE email = :email");
		$this->db->bind(":email", $email);
		$row = $this->db->single();
		if($this->db->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function getUserProducts() {
		$this->db->query("SELECT * FROM products WHERE uid = :id");
		$this->db->bind(":id", $_SESSION['user_id']);
		return $this->db->resultSet(true);
	}


	public function deleteProduct($pid) {
		$this->db->query("SELECT imagePath FROM products WHERE pid=:pid");
		$this->db->bind(":pid", $pid);
		$target = $this->db->single();

		$this->db->query("DELETE FROM products WHERE pid=:pid");
		$this->db->bind(":pid", $pid);

		if($this->db->execute()){
			if($target->imagePath != '/default.png') {
				unlink(dirname(APPROOT) . '/public/images/products/' . $target->imagePath);
			}
			return true;
		}else{
			return false;
		}
	}

}
