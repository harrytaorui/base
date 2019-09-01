<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

	class Users extends Controller{
		public function __construct(){
			if(isLoggedIn()) {
				redirect('account');
            }
			$this->userModel = $this->model('UserModel');
		}

		public function registration(){
            // Check for POST submission
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Validate input data from registration form
                $data = $this->validateRegisterForm();
                $data['password'] = password_hash($data['origin_password'], PASSWORD_DEFAULT);
                if($this->userModel->registerUser($data)) {
                    var_dump($this->sendConfirmationEmail($data));
                    flash('register_success', 'You are now registered and can login');
                    redirect('users/registration');
                    
                } else {
                    // Load view with errors
                    $this->view('includes/header');
                    $this->view('users/registration?fail=true', $data);
                    $this->view('includes/footer');
                }

            } else {
                // Display new registration form
                $data = [
                    'email' => '',
                    'username' => '',
                    'password' => '',
                    'confirm_password' => '',
                ];

                $this->view('includes/header');
                $this->view('users/registration', $data);
                $this->view('includes/footer');
            }
        }

        /**
         * Handles loading new login view or handles login if login POST method is used
         * POST method used: validates user email/username and password, if successful will
         *      create new session and calls createUserSession() which will reroute to home page
         */
        public function login() {
            // Check for POST submission
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = $this->validateLoginForm();
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                $this->saveLoginCookie($data);
                if($loggedInUser && $_SESSION['captcha_text'] == $data['captcha']) {
                    $this->createUserSession($loggedInUser);
                } else {
                    if ($_SESSION['captcha_text'] != $data['captcha']) {
                        flash('login_failed', 'wrong captcha entered!',"alert alert-danger");
                    } else {
                        flash('login_failed', 'Incorrect username or password','alert alert-danger',"alert alert-danger");
                    }
                    $this->view('includes/header');
                    $this->view('users/registration', $data);
                    $this->view('includes/footer');
                    
                    }
            } else {
                $data = [
                    'username' => '',
                    'password' => '',
                ];
                $this->view('includes/header');
                $this->view('users/registration', $data);
                $this->view('includes/footer');
            }
        }

        public function saveLoginCookie($data){
            if($data["remember"]) {
                setcookie ("username",$data['username'],time()+ 3600,'/');
            } else {
                setcookie("username",null,1, '/');
            }
        }

        public function createUserSession($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            redirect('home');
        }

        /**
         * Unsets user_id, user_name, user_email, user_username variables then destroys session
         * and return to home page
         */
        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            session_destroy();
            session_start();
            flash('logout_success', 'You have successfully logged out');
            redirect('home');
        }

        private function validateRegisterForm() {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $verify_code = rand(100000,999999);
            $data = [
                'email' => trim($_POST['email']),
                'username' => trim($_POST['username']),
                'origin_password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['conpass']),
                'verify_code' => $verify_code,
            ];
            return $data;
        }

        /**
         * Sanitizes POST input from form and checks for erros
         * Error messages conatined in associative array return value
         * 
         * @return: $data associative array of input and error messages
         */
        private function validateLoginForm() {
            // Submit form data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['user_name']),
                'password' => trim($_POST['pass_word']),
                'remember' => isset($_POST['remember']),
                'captcha' => trim($_POST['captcha_challenge']),
            ];

            return $data;
        }

        public function validation_check(){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $result = true;
            if(isset($_POST['username'])) {
                $username = $_POST['username'];
                $result = $this->userModel->findUserByUsername($username);
            } else if (isset($_POST['email'])) {
                $email = $_POST['email'];
                $result = $this->userModel->findUserByEmail($email);
            }
            if ($result) {
                echo "1";
            } else {
                echo "0";
            }
        }

        public function sendConfirmationEmail($data) {
            require_once dirname(APPROOT).'/public/vendor/autoload.php';
            $mail = new PHPMailer(true);

        try {
            // Setup server settings
            //$mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'mailhub.eait.uq.edu.au';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 25;

            // Set recipients
            $mail->setFrom('noreply@its.uq.edu.au', 'Buyit');
            $mail->addAddress($data['email']);

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification for '.$data['username'].'';
            $mail->Body = '<h3>Thanks for signing up, '.$data['username'].'!</h3>
                <br><br>
                Your account has been created.<br> 
                Here are your login details.<br>
                -------------------------------------------------<br>
                <h4>Username: ' . $data['username'] . '</h4><br>
                <h4>Email   : ' . $data['email'] . '</h4><br>
                <h4>Password: ' . $data['origin_password'] . '</h4><br>
                -------------------------------------------------<br>
                <br><br>                
                Please enter your verification code below in your user profile to activate your account:<br>
                <br>        
                <h3>Verification code: </h3><h1>'.$data['verify_code'].'</h1>';

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo 'Message could not be sent: ', $mail->ErrorInfo;
            return false;
        }
        }

	}
