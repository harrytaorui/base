<?php
class Account extends Controller{

	public function __construct(){
		if(!isLoggedIn()) {
			redirect('users/login');
		}

		$this->accountModel = $this->model('AccountModel');
	}

	public function index() {
		$uri = $_SERVER['REQUEST_URI'];
		$category = substr($uri,strpos($uri,'?')+1);
		if(strpos($category,'delete')!==false){
			$productID =(int) substr($category,strpos($category,'=')+1);
			$result = $this->accountModel->deleteProduct($productID);
			if($result){
				flash('delete_success', "Product deleted!");
				$result = $this->accountModel->getUserProducts();
				$result = (array)$result;
				$data = [
					'name' => $_SESSION['username'],
					'products' => $result,
					'uri' => $uri,
					'category' => $category
				];

				$this->view('includes/header');
				$this->view('account/index', $data);
				$this->view('includes/footer');
			} else {
				echo 'Error deleting product';
			}
		} else{
			$result = $this->accountModel->getUserProducts();
			$result = (array)$result;
			
			$data = [
				'name' => $_SESSION['username'],
				'products' => $result,
				'uri' => $uri,
				'category' => $category
			];

			$this->view('includes/header');
			$this->view('account/index', $data);
			$this->view('includes/footer');
		}

	}


	public function edit(){
		$activated = $this->accountModel-> getCurrentUser()->activated;
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$data = $this->sanitizeInput();
			$data['activated'] = $activated;
			if(empty($data['username'])){
				$data['error_username'] = "Please enter username";
			}

			if(empty($data['email'])){
				$data['error_email'] = "Please enter email";
			}else if($this->accountModel->findUserByEmail($data['email'])) {
				if($data['email']!=$_SESSION['email']){
					$data['error_email'] = "Email is already taken";
				}
			}

			if(empty($data['error_username']) && empty($data['error_email'])){
				if($this->accountModel->updateProfile($data)){
					$this -> updateSession($data);
					flash('update_success', "Profile updated successfully!");
					redirect("account/edit");
				}else{
					die("Failed to update user profile");
				}
			}else{
				$this->view('includes/header');
				$this->view('account/edit', $data);
				$this->view('includes/footer');
			}

		}else{
			$data = [
				'id' => $_SESSION['user_id'],
				'username' => $_SESSION['username'],
				'email' => $_SESSION['email'],
				'activated' => $activated,
				'error_username' => '',
				'error_email' => '',
			];
			$this->view('includes/header');
			$this->view('account/edit', $data);
			$this->view('includes/footer');
		}

	}

	public function verify(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$_POST = filter_input_array(INPUT_POST, FILTER_VALIDATE_INT);
			$data = [
				'id' => $_SESSION['user_id'],
				'username' => $_SESSION['username'],
				'email' => $_SESSION['email'],
				'verify' => $_POST['verify_code'],
				'error_username' => '',
				'error_email' => '',
			];
			if($this->accountModel->verify_email($data['username'],$data['verify'])){
				$data['activated'] = 1;
				flash('verify_success', "Your Email is successfully verified!");
				$this->view('includes/header');
				$this->view('account/edit', $data);
				$this->view('includes/footer');
			} else {
				$data['activated'] = 0;
				flash('verify_fail', "Your Email verification failed!","alert alert-danger");
				$this->view('includes/header');
				$this->view('account/edit', $data);
				$this->view('includes/footer');

			}
		}
	}

	//---------------------------------------- HELPER FUNCTIONS -----------------------------------------//

	private function sanitizeInput() {
			// Santise POST data from form
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Retrieve data from forms
			$data = [
				'id' => $_SESSION['user_id'],
				'username' => trim($_POST['username']),
				'email' => trim($_POST['email']),
				'error_username' => '',
				'error_email' => '',
			];
			return $data;
	}


	private function updateSession($data){
		$_SESSION['username'] = $data['username'];
		$_SESSION['email'] = $data['email'];
	}
}
