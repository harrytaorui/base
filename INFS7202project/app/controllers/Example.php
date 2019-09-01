<?php
	class Example extends Controller{
		public function __construct(){
			$this->testModel = $this->model('ExampleModel');
		}

		/**
		 * Example page
		 * DO NOT USE
		 */
		public function index(){
			$users = $this->testModel->getUsers();

			$data = [
				'title' => 'Welcome Peasants to the Example page!',
				'users' => $users
			];

			$this->view('includes/header');
			$this->view('example/example', $data);
			$this->view('includes/footer');
		}
	}