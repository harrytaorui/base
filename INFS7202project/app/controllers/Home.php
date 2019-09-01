<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(APPROOT).'/public/vendor/autoload.php';

/**
 * Default and main page controller.
 * Views are located in /views/home/ folder
 */
class Home extends Controller{
	public function __construct(){
		$this->ProductModel = $this->model('ProductModel');
		$this->userModel = $this->model('UserModel');
	}

	/**
	 * Loads front page of website
	 */
	public function index(){

		$products = $this->ProductModel->getAllProducts();
		$newProduct = $this->ProductModel->getNewProducts();
		$uid = $products[0]-> uid;
		$uploader = $this->userModel->getUser($uid);
		$averageRatings = [];
		for ($x = 0; $x < sizeof($newProduct); $x++) {
			$average = $this->ProductModel->getAverageRating($newProduct[$x]->pid);
			$averageRatings[$x] = $average;
		}
		$data = [
			'newProduct' => $newProduct,
			'uploader' => $uploader,
			'average' => $averageRatings
		];
		$this->view('includes/header');
		$this->view('home/index', $data);
		$this->view('includes/footer');
		$this->script('script.js');
	}

	/**
	 * Loads About page, with form for sending email query to admin
	 */
	public function about(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'subject' => trim($_POST['subject']),
				'body' => trim($_POST['body']),
				'replyTo' => trim($_POST['replyTo']),

				'subject_error' => '',
				'body_error' => '',
				'replyTo_error' => '',
			];
			// Validate input
			if(empty($data['subject'])) {
                $data['subject_error'] = 'Please enter a subject';
			}
			if(empty($data['body'])) {
                $data['body_error'] = 'Please enter a message';
			}
			if(empty($data['replyTo'])) {
                $data['replyTo_error'] = 'Please enter your email to reply to';
            } else if (!filter_var($data['replyTo'], FILTER_VALIDATE_EMAIL)) {
				$data['replyTo_error'] = 'Please enter a valid email';
			}
			// If no errors then send email
			if (empty($data['subject_error']) && empty($data['body_error']) && empty($data['replyTo_error'])) {
				$result = $this->sendMail($data['subject'], $data['body'], $data['replyTo'] );
				if ($result) {
					flash('email_success', 'Your enquiry has been successfully sent');
				}
			}
		} else {
			$data = [
				'subject' => '',
				'body' => '',
				'replyTo' => '',

				'subject_error' => '',
				'body_error' => '',
				'replyTo_error' => '',
			];
		}

		$this->view('includes/header');
		$this->view('home/about', $data);
		$this->view('includes/footer');
	}

}
