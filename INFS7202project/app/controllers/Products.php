<?php
	class Products extends Controller{
		public function __construct(){
			$this->ProductModel = $this->model('ProductModel');
		}

		public function index() {
			$this->view('includes/header');
			echo '<div class="col-12 text-center">Error 404: page not found</div>';
			$this->view('includes/footer');
		}


		public function display($ProductID = null) {
			// Redirect to Product search page (default) if no Product id is provided
			if($ProductID == null) {
				redirect('Products');
			}

			// Get Product data
			$ProductData = $this->ProductModel->getProductData($ProductID);

			// If Product does not exist redirect to search page
			if($ProductData == null) {
				redirect('Products');
			}

			$comments = $this->ProductModel->getAllComments($ProductID);

			// Display Product by Product id
			$data = [
				'pid' => $ProductID,
				'short_des' => $ProductData->short_des,
				'uid' => $ProductData->uid,
				'long_des' => $ProductData->long_des,
				'quantity' => $ProductData->quantity,
				'price' => $ProductData->price,
				'imagePath' => $ProductData->imagePath,
				'comments' => $comments,
			];

			$this->view('includes/header');
			$this->view('Products/display', $data);
			$this->view('includes/footer');
			$this->script('comment');
		}

        public function upload() {
			if(!isLoggedIn()) {
				redirect('users/login');
			}
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$data = $this->validateCreateProduct();
				if(empty($data['ProductName_error']) && empty($data['description_error']) &&
						empty($data['quantity_error']) && empty($data['price_error']) &&
						empty($data['img_error'])){
					$data['img'] = $_FILES['imgPreview'];
					$data['uid'] = $_SESSION['user_id'];
					$upload = $this->ProductModel->uploadNewProduct($data);
					if($upload) {
						flash('upload_success', "Product successfully uploaded!");
						redirect('account/index');
					} else {
						$this->view('includes/header');
						$this->view('Products/upload', $data);
						$this->view('includes/footer');
						$this->script('upload');
					}
				} else {
					$this->view('includes/header');
					$this->view('Products/upload', $data);
					$this->view('includes/footer');
					$this->script('upload');
				}
			} else {
				$data = [
	                'short_des' => '',
	                'long_des' => '',
	                'quantity' => '',
					'price' => '',
	                'ProductName_error' => '',
	                'description_error' => '',
	                'quantity_error' => '',
					'price_error' => '',
					'img_error' => '',
				];

				$this->view('includes/header');
				$this->view('Products/upload', $data);
				$this->view('includes/footer');
				$this->script('upload');
			}
		}

		public function edit($ProductID = null) {
			$ProductData = $this->ProductModel->getProductData($ProductID);
			if($ProductData == null) {
				redirect('Products');
			}
			if(!isLoggedIn()) {
				redirect('users/login');
			} elseif($_SESSION['user_id'] != $ProductData->uid) {
				$this->view('includes/header');
				echo '<div class="col-12 text-center">Sorry you cannot edit someone else\'s Product</div>';
				$this->view('includes/footer');
				return;
			}

			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$data = $this->validateEditProduct();
				$data['pid'] = $ProductID;
				$data['imagePath'] = $ProductData->imagePath;
				if(empty($data['ProductName_error']) && empty($data['description_error']) &&
						empty($data['quantity_error']) && empty($data['price_error']) &&
						empty($data['img_error'])){
					if($this->ProductModel->updateProduct($data)) {
						flash('update_success', 'You have successfully updated your Product');
						redirect('account');
					} else {
						echo 'TODO: uh-oh: PDOException was thrown';
						$this->view('includes/header');
						$this->view('Products/edit', $data);
						$this->view('includes/footer');
					}
				} else {
					$this->view('includes/header');
					$this->view('Products/edit', $data);
					$this->view('includes/footer');
				}
			} else {
				$data = [
					'pid' => $ProductID,
					'short_des' => $ProductData->short_des,
					'long_des' => $ProductData->long_des,
					'quantity' => $ProductData->quantity,
					'price' => $ProductData->price,
					'imagePath' => $ProductData->imagePath,

					'ProductName_error' => '',
					'description_error' => '',
					'quantity_error' => '',
					'price_error' => '',
					'img_error' => '',
				];

				$this->view('includes/header');
				$this->view('Products/edit', $data);
				$this->view('includes/footer');
			}
		}

		//---------------------------------------- HELPER FUNCTIONS -----------------------------------------//

		private function sanitizeInput() {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'short_des' => trim($_POST['ProductName']),
                'long_des' => trim($_POST['desc']),
                'quantity' => trim($_POST['quantity']),
				'price' => trim($_POST['price']),
                'ProductName_error' => '',
                'description_error' => '',
                'quantity_error' => '',
				'price_error' => '',
				'img_error' => '',
            ];
            return $data;
		}


		private function validateCreateProduct() {
			$data = $this->sanitizeInput();
			if (empty($data['short_des'])) {
				$data['ProductName_error'] = 'Please enter the name of your Product';
			}
			if (empty($data['long_des'])) {
				$data['description_error'] = 'Please enter a description of your Product';
			}
			if (empty($data['quantity'])) {
				$data['quantity_error'] = 'Please enter the quantity of your Product';
			}
			if (empty($data['price'])) {
				$data['price_errorr'] = 'Please enter your price';
			}

			$data['img_error'] = $this->checkImageUpload($_FILES['imgPreview']);

			return $data;
		}

		private function validateEditProduct() {
			$data = $this->sanitizeInput();

			if (empty($data['short_des'])) {
				$data['ProductName_error'] = 'Please enter the name of your Product';
			}
			if (empty($data['long_des'])) {
				$data['description_error'] = 'Please enter a description of your Product';
			}
			if (empty($data['quantity'])) {
				$data['quantity_error'] = 'Please enter the quantity of your Product';
			}
			if (empty($data['price'])) {
				$data['price_errorr'] = 'Please enter your price';
			}
			

			return $data;
		}

		private function checkImageUpload($imgTemp) {
			if($imgTemp['size'] > 2097152) {
				return 'Please select an image less than 2MB';
			}
			if($imgTemp['error'] > 0 && $imgTemp['error'] != 4) {
				return 'File has an error (Error: '.$imgTemp['error'].')';
			}
			return '';
		}



}
